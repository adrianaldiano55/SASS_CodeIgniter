<?php

namespace App\Controllers;

use App\Models\FilesModel;
use CodeIgniter\HTTP\ResponseInterface;

class Documents extends BaseController
{
    private const MAX_FILE_SIZE = 15 * 1024 * 1024;

    private const ALLOWED_REQUIREMENTS = [
        'DSWD Certificate',
        'SAP Form 1',
        'SAP Form 2',
        '2pc. 1x1 ID Picture',
        'Photocopy of School ID Back to Back',
        'Photocopy of School Enrollment',
        'Grades from 1st Year to Current Year',
        'SAP Form 3',
        'Medical Certificate',
    ];

    private const ALLOWED_MIME_TYPES = [
        'application/pdf',
        'application/msword',
        'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        'image/jpeg',
        'image/png',
    ];

    public function create_File(): ResponseInterface
    {
        $userId = session()->get('id');
        if (!$userId) {
            return $this->jsonError('You must be logged in.', 401);
        }
        $fileRole = trim((string) $this->request->getPost('fileRole'));
        if (!in_array($fileRole, self::ALLOWED_REQUIREMENTS, true)) {
            return $this->jsonError('Invalid document requirement.', 422);
        }
        $file = $this->request->getFile('document');
        if ($file === null || !$file->isValid()) {
            return $this->jsonError('Please choose a valid document to upload.', 422);
        }
        if ($file->getSize() > self::MAX_FILE_SIZE) {
            return $this->jsonError('File is too large. Maximum size is 15 MB.', 413);
        }
        $mimeType = $file->getMimeType();
        if ($mimeType !== 'application/pdf') {
            return $this->jsonError('Only PDF files are allowed for these requirements.', 415);
        }
        $fileData = file_get_contents($file->getTempName());
        if ($fileData === false) {
            return $this->jsonError('Unable to read the uploaded file.', 500);
        }
        $filesModel = new FilesModel();
        $insertedId = $filesModel->insert([
            'userId' => $userId,
            'fileName' => $file->getClientName(),
            'fileType' => $mimeType,
            'fileSize' => $file->getSize(),
            'fileData' => $fileData,
            'fileRole' => $fileRole,
            'fileStatus' => 'Pending',
            'critic' => null,
            'upload_at' => date('Y-m-d H:i:s'),
        ]);
        if ($insertedId === false) {
            return $this->response
                ->setStatusCode(500)
                ->setJSON([
                    'success' => false,
                    'message' => 'Unable to save the uploaded document.',
                    'errors' => $filesModel->errors(),
                ]);
        }
        return $this->response->setJSON([
            'success' => true,
            'message' => 'Document uploaded successfully.',
        ]);
    }

    public function status(): ResponseInterface
    {
        $userId = session()->get('id');
        if (!$userId) {
            return $this->jsonError('You must be logged in.', 401);
        }
        $files = (new FilesModel())
            ->select('id, fileName, fileType, fileSize, fileRole, fileStatus, critic, upload_at')
            ->where('userId', $userId)
            ->orderBy('upload_at', 'DESC')
            ->findAll();
        return $this->response->setJSON([
            'success' => true,
            'files' => $files,
        ]);
    }

    public function view_File(int $id): ResponseInterface
    {
        $file = $this->findOwnedFile($id);
        if ($file === null) {
            return $this->response->setStatusCode(404)->setBody('File not found.');
        }
        return $this->response
            ->setContentType($file['fileType'])
            ->setHeader('Content-Disposition', 'inline; filename="' . rawurlencode($file['fileName']) . '"')
            ->setBody($file['fileData']);
    }

    public function delete_File(int $id): ResponseInterface
    {
        $userId = session()->get('id');
        if (!$userId) {
            return $this->jsonError('You must be logged in.', 401);
        }

        $filesModel = new FilesModel();
        $file = $filesModel->where('id', $id)->where('userId', $userId)->first();
        if (!$file) {
            return $this->jsonError('Document not found.', 404);
        }
        if (!$filesModel->delete($id)) {
            return $this->jsonError('Unable to delete the document.', 500);
        }

        return $this->response->setJSON([
            'success' => true,
            'message' => 'Document deleted successfully.',
        ]);
    }

    public function update_File(int $id): ResponseInterface
    {
        $userId = session()->get('id');
        if (!$userId) {
            return $this->jsonError('You must be logged in.', 401);
        }
        $filesModel = new FilesModel();
        $existingFile = $filesModel->where('id', $id)->where('userId', $userId)->first();
        if (!$existingFile) {
            return $this->jsonError('Document not found.', 404);
        }
        $file = $this->request->getFile('document');
        if ($file === null || !$file->isValid()) {
            return $this->jsonError('Please choose a valid document to upload.', 422);
        }
        if ($file->getSize() > self::MAX_FILE_SIZE) {
            return $this->jsonError('File is too large. Maximum size is 15 MB.', 413);
        }
        $mimeType = $file->getMimeType();
        if (!in_array($mimeType, self::ALLOWED_MIME_TYPES, true)) {
            return $this->jsonError('Only PDF, Word, JPEG, and PNG files are allowed.', 415);
        }
        $fileData = file_get_contents($file->getTempName());
        if ($fileData === false) {
            return $this->jsonError('Unable to read the uploaded file.', 500);
        }
        if (!$filesModel->update($id, [
            'fileName' => $file->getClientName(),
            'fileType' => $mimeType,
            'fileSize' => $file->getSize(),
            'fileData' => $fileData,
            'fileStatus' => 'Pending',
            'critic' => null,
            'upload_at' => date('Y-m-d H:i:s'),
        ])) {
            return $this->response
                ->setStatusCode(500)
                ->setJSON([
                    'success' => false,
                    'message' => 'Unable to update the document.',
                    'errors' => $filesModel->errors(),
                ]);
        }
        return $this->response->setJSON([
            'success' => true,
            'message' => 'Document updated successfully.',
        ]);
    }

    private function findOwnedFile(int $id): ?array
    {
        $userId = session()->get('id');
        if (!$userId) {
            return null;
        }
        $file = (new FilesModel())
            ->where('id', $id)
            ->where('userId', $userId)
            ->first();
        return $file ?: null;
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

    // Faculty Functions

    public function requirements(): ResponseInterface
    {
        $userId = session()->get('id');
        if (!$userId) {
            return $this->jsonError('You must be logged in.', 401);
        }
        $files = (new FilesModel())
            ->select('id, fileName, fileType, fileSize, fileRole, fileStatus, critic, upload_at')
            ->where('fileStatus', 'pending')
            ->orderBy('upload_at', 'DESC')
            ->findAll();
        return $this->response->setJSON([
            'success' => true,
            'files' => $files,
        ]);
    }

}
