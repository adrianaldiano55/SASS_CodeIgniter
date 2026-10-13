<?php

namespace App\Controllers;

use App\Models\FilesModel;
use App\Models\UsersModel;
use CodeIgniter\HTTP\ResponseInterface;

class Faculty extends BaseController
{
    private const PENDING_STATUSES = ['pending', 'Pending', 'PENDING'];

    public function verifications(): ResponseInterface
    {
        $users = (new UsersModel())
            ->whereIn('status', self::PENDING_STATUSES)
            ->orderBy('created_at', 'ASC')
            ->findAll();

        return $this->response->setJSON([
            'success' => true,
            'users' => array_map(
                fn (array $user): array => $this->formatVerificationUser($user),
                $users
            ),
        ]);
    }

    public function verification(int $id): ResponseInterface
    {
        $user = (new UsersModel())
            ->where('id', $id)
            ->whereIn('status', self::PENDING_STATUSES)
            ->first();

        if (!$user) {
            return $this->jsonError('Pending user verification not found.', 404);
        }

        return $this->response->setJSON([
            'success' => true,
            'user' => $this->formatVerificationUser($user),
        ]);
    }

    public function reviewVerification(int $id): ResponseInterface
    {
        $status = strtolower(trim((string) $this->request->getPost('status')));
        if (!in_array($status, ['approved', 'declined'], true)) {
            return $this->jsonError('Choose approve or decline for this account.', 422);
        }

        $remark = trim((string) $this->request->getPost('remark'));
        if ($status === 'declined' && $remark === '') {
            return $this->jsonError('A reason is required when declining an account.', 422);
        }

        $usersModel = new UsersModel();
        $user = $usersModel
            ->where('id', $id)
            ->whereIn('status', self::PENDING_STATUSES)
            ->first();

        if (!$user) {
            return $this->jsonError('Pending user verification not found.', 404);
        }

        if (!$usersModel->update($id, [
            'status' => $status,
            'verification_remark' => $remark !== '' ? $remark : null,
        ])) {
            return $this->jsonError('Unable to update the user verification.', 500);
        }

        return $this->response->setJSON([
            'success' => true,
            'message' => $status === 'approved'
                ? 'User account approved successfully.'
                : 'User account declined.',
        ]);
    }

    public function pendingCounts(): ResponseInterface
    {
        $verificationCount = (new UsersModel())
            ->whereIn('status', self::PENDING_STATUSES)
            ->countAllResults();
        $documentCount = (new FilesModel())
            ->whereIn('fileStatus', self::PENDING_STATUSES)
            ->countAllResults();

        return $this->response->setJSON([
            'success' => true,
            'documents' => $documentCount,
            'verifications' => $verificationCount,
        ]);
    }

    private function formatVerificationUser(array $user): array
    {
        $fullName = trim(implode(' ', array_filter([
            $user['firstname'] ?? '',
            $user['middlename'] ?? '',
            $user['lastname'] ?? '',
        ], static fn ($name): bool => trim((string) $name) !== '')));

        return [
            'id' => $user['id'],
            'login_id' => $user['loginId'] ?? '',
            'username' => $fullName !== '' ? $fullName : ($user['loginId'] ?? ''),
            'email' => $user['email'] ?? '',
            'role' => $user['role'] ?? '',
            'created_at' => $user['created_at'] ?? 'Not recorded',
            'verification_status' => $user['status'] ?? 'Pending',
            'sex' => $user['sex'] ?? '',
            'age' => $user['age'] ?? '',
            'program' => $user['program'] ?? '',
            'year' => $user['year'] ?? '',
            'contact' => $user['contact'] ?? '',
            'address' => $user['address'] ?? '',
            'verification_remark' => $user['verification_remark'] ?? '',
        ];
    }

    private function jsonError(string $message, int $statusCode): ResponseInterface
    {
        return $this->response
            ->setStatusCode($statusCode)
            ->setJSON([
                'success' => false,
                'message' => $message,
            ]);
    }
}
