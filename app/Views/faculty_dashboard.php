<?php
$userProfile = $userProfile ?? [];
$profileName = $profileName ?? trim(implode(' ', array_filter([
    $userProfile['firstname'] ?? '',
    $userProfile['middlename'] ?? '',
    $userProfile['lastname'] ?? '',
])));
$profileName = $profileName !== '' ? $profileName : ($userProfile['loginId'] ?? 'User');
$profileDetails = $profileDetails ?? [];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Faculty Dashboard</title>
    <meta name="description" content="SASS Faculty Dashboard">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?= esc(csrf_hash()) ?>">
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <style>

        html,
        body {
            width: 100%;
            height: 100%;
            margin: 0;
        }

        body {
            background-color: #f8f9fa;
            overflow-x: hidden;
        }

        .page-wrapper {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* =========================
        NAVBAR
        ========================== */

        .top-navbar {
            height: 70px;
            flex-shrink: 0;
        }

        .nav-icon-btn {
            width: 42px;
            height: 42px;

            display: flex;
            align-items: center;
            justify-content: center;

            border: none;
            background-color: #f8f9fa;
            color: #495057;

            transition: all .2s ease;
        }

        .nav-icon-btn:hover {
            background-color: #e9ecef;
            color: #0d6efd;
            transform: translateY(-1px);
        }

        .nav-icon-btn i {
            font-size: 1.25rem;
        }

        /* =========================
        CONTENT
        ========================== */

        .content-area {
            flex: 1;
            padding: 1.5rem;
            overflow-y: auto;
        }

        /* =========================
        FEATURE CARDS
        ========================== */

        .feature-button {
            width: 100%;
            border: none;
            background: transparent;
            padding: 0;
            text-align: left;
            color: inherit;
        }

        .feature-card {
            display: block;
            height: 100%;
            cursor: pointer;
            transition: all .2s ease;
        }

        .feature-button:hover .feature-card {
            transform: translateY(-3px);
        }

        .feature-button:hover .card {
            box-shadow:
                0 .5rem 1rem rgba(0, 0, 0, .12) !important;
        }

        .feature-button:disabled .feature-card {
            opacity: .75;
            transform: none;
        }

        .feature-button:disabled .card {
            background-color: #e9ecef;
            box-shadow: none !important;
        }

        .feature-icon {
            width: 48px;
            height: 48px;

            display: flex;
            align-items: center;
            justify-content: center;

            border-radius: 12px;

            background-color: #e7f1ff;
            color: #0d6efd;

            font-size: 1.4rem;
        }

        /* =========================
        TABLE
        ========================== */

        .table-card {
            border: 0;
            box-shadow: 0 .125rem .25rem rgba(0,0,0,.075);
        }

        .table th {
            white-space: nowrap;
            font-size: .85rem;
        }

        .table td {
            vertical-align: middle;
        }

        /* =========================
        STATUS
        ========================== */

        .status-badge {
            padding: .45rem .75rem;
            border-radius: 50px;
            font-size: .8rem;
            font-weight: 500;
        }

        /* =========================
        MODAL
        ========================== */

        .document-preview {
            width: 100%;
            height: 500px;
            border: 1px solid #dee2e6;
            border-radius: 8px;
        }

        .user-info-label {
            font-size: .75rem;
            color: #6c757d;
            margin-bottom: 2px;
        }

        .user-info-value {
            font-weight: 500;
        }

        /* =========================
        FOOTER
        ========================== */

        .page-footer {
            flex-shrink: 0;
        }

        @media (max-width: 767.98px) {

            .top-navbar {
                height: auto;
                min-height: 65px;
            }

            .content-area {
                padding: 1rem;
            }

            .navbar-brand {
                font-size: .95rem !important;
            }
        }
    

        /* Compact notification dropdown */
        .notification-dropdown {
            width: min(340px, calc(100vw - 1.5rem));
            padding: 0;
            border: 0;
            border-radius: 12px;
            overflow: hidden;
            margin-top: .65rem !important;
        }
        .notification-dropdown-title {
            padding: .9rem 1rem;
            font-weight: 700;
            border-bottom: 1px solid #edf0f2;
            background: #f8fbfc;
        }
        .notification-item {
            display: flex;
            align-items: center;
            gap: .75rem;
            padding: .85rem 1rem;
            border-bottom: 1px solid #edf0f2;
        }
        .notification-item-icon {
            width: 38px;
            height: 38px;
            flex: 0 0 38px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
            background: #e7f1ff;
            color: #0d6efd;
            font-size: 1.1rem;
        }
        .notification-item:last-child { border-bottom: 0; }
        .notification-item .btn { white-space: nowrap; }
        @media (max-width: 480px) {
            .notification-dropdown { position: fixed !important; top: 65px !important; right: .5rem !important; left: auto !important; }
        }

        /* Profile details dropdown */
        .profile-dropdown {
            width: min(460px, calc(100vw - 2rem));
            white-space: normal;
            border: 0;
            border-radius: 14px;
            overflow: hidden;
            margin-top: .65rem !important;
        }
        .profile-dropdown-header {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1.15rem 1.25rem;
            background: #eaf4f7;
        }
        .profile-avatar {
            width: 58px;
            height: 58px;
            flex: 0 0 58px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background: #cfe2ff;
            color: #34556d;
            font-size: 1.9rem;
        }
        .profile-name {
            font-weight: 700;
            font-size: 1rem;
            overflow-wrap: anywhere;
        }
        .profile-email {
            color: #6c757d;
            font-size: .85rem;
            overflow-wrap: anywhere;
        }
        .profile-details-title {
            padding: 1rem 1.25rem .5rem;
            font-weight: 700;
            font-size: 1rem;
        }
        .profile-details-table {
            padding: 0 1.25rem .75rem;
        }
        .profile-detail-row {
            display: grid;
            grid-template-columns: minmax(115px, .9fr) minmax(0, 1.1fr);
            gap: .75rem;
            padding: .55rem 0;
            border-bottom: 1px solid #edf0f2;
            font-size: .875rem;
        }
        .profile-detail-row:last-child { border-bottom: 0; }
        .profile-detail-row span { color: #6c757d; }
        .profile-detail-row strong {
            font-weight: 600;
            text-align: right;
            overflow-wrap: anywhere;
        }
        .profile-dropdown-footer {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            gap: .5rem;
            padding: .85rem 1.25rem 1rem;
            background: #f8f9fa;
            border-top: 1px solid #edf0f2;
        }
        .profile-full-table th { width: 35%; }
        .profile-full-table td { overflow-wrap: anywhere; }
        @media (max-width: 480px) {
            .profile-dropdown { position: fixed !important; top: 65px !important; right: .5rem !important; left: auto !important; }
            .profile-dropdown-footer { flex-direction: column; }
            .profile-dropdown-footer .btn { width: 100%; }
        }

    </style>
</head>
<body>

<div class="page-wrapper">
    <!-- =====================================================
    TOP NAVBAR
    ====================================================== -->
    <header
        class="navbar navbar-expand-lg navbar-light bg-white border-bottom top-navbar px-3"
    >
        <div class="container-fluid">
            <span class="navbar-brand mb-0 h1 fs-5">
                Student Assistant Submission System
            </span>
            <div class="ms-auto d-flex align-items-center gap-2">
                <!-- Faculty notifications dropdown -->
                <div class="dropdown">
                    <button type="button" class="btn nav-icon-btn rounded-circle position-relative"
                            id="facultyNotificationsDropdown" data-bs-toggle="dropdown"
                            aria-expanded="false" title="Notifications" aria-label="Notifications">
                        <i class="bi bi-bell"></i>
                        <span id="facultyNotificationTotal" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger d-none">0</span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end notification-dropdown shadow"
                        aria-labelledby="facultyNotificationsDropdown">
                        <div class="notification-dropdown-title d-flex justify-content-between align-items-center">
                            <span>Pending Reviews</span><span class="badge bg-primary">Faculty</span>
                        </div>
                        <div class="notification-item">
                            <div class="notification-item-icon"><i class="bi bi-file-earmark-text"></i></div>
                            <div class="flex-grow-1">
                                <div class="fw-semibold small">New Documents</div>
                                <div class="text-muted small">Documents awaiting review</div>
                            </div>
                            <span id="notificationDocumentCount" class="badge bg-warning text-dark">0</span>
                            <button type="button" class="btn btn-sm btn-outline-primary" onclick="showDocuments()">View</button>
                        </div>
                        <div class="notification-item">
                            <div class="notification-item-icon"><i class="bi bi-person-check"></i></div>
                            <div class="flex-grow-1">
                                <div class="fw-semibold small">New Users</div>
                                <div class="text-muted small">Accounts awaiting verification</div>
                            </div>
                            <span id="notificationVerificationCount" class="badge bg-warning text-dark">0</span>
                            <button type="button" class="btn btn-sm btn-outline-primary" onclick="showVerifications()">View</button>
                        </div>
                        <div class="px-3 py-2 text-muted small border-top">Counts show items currently pending review.</div>
                    </div>
                </div>
                <!-- Profile details dropdown -->
                <div class="dropdown">
                    <button
                        type="button"
                        class="btn nav-icon-btn rounded-circle"
                        id="facultyProfileDropdown"
                        data-bs-toggle="dropdown"
                        aria-expanded="false"
                        title="View profile details"
                        aria-label="View profile details">
                        <i class="bi bi-person-circle"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end profile-dropdown p-0 shadow"
                        aria-labelledby="facultyProfileDropdown">
                        <div class="profile-dropdown-header">
                            <div class="profile-avatar"><i class="bi bi-person-workspace"></i></div>
                            <div class="min-w-0">
                                <div class="profile-name">
                                    <?= esc($profileName) ?>
                                </div>
                                <div class="profile-email">
                                    <?= esc($userProfile['email'] ?? 'Email not available') ?>
                                </div>
                            </div>
                        </div>
                        <div class="profile-details-title">Account Summary</div>
                        <div class="profile-details-table">
                            <div class="profile-detail-row"><span>Login ID</span><strong><?= esc($userProfile['loginId'] ?? 'Not provided') ?></strong></div>
                            <div class="profile-detail-row"><span>Role</span><strong><?= esc($userProfile['role'] ?? 'Not provided') ?></strong></div>
                            <div class="profile-detail-row"><span>Account Status</span><strong><?= esc($userProfile['status'] ?? 'Not provided') ?></strong></div>
                        </div>
                        <div class="profile-dropdown-footer">
                            <button type="button" class="btn btn-sm btn-outline-primary"
                                    data-bs-toggle="modal" data-bs-target="#userProfileModal">
                                <i class="bi bi-person-lines-fill me-1"></i> View Full Information
                            </button>
                            <a href="<?= site_url('logout') ?>" class="btn btn-sm btn-outline-danger">
                                <i class="bi bi-box-arrow-right me-1"></i> Log Out
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <div class="modal fade" id="userProfileModal" tabindex="-1" aria-labelledby="userProfileModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <div>
                        <h5 class="modal-title" id="userProfileModalLabel">Full User Information</h5>
                        <div class="text-muted small"><?= esc($profileName) ?></div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped align-middle profile-full-table mb-0">
                            <tbody>
                            <?php foreach ($profileDetails as $detail): ?>
                                <tr>
                                    <th scope="row"><?= esc($detail['label']) ?></th>
                                    <td><?= esc((string) $detail['value'] !== '' ? $detail['value'] : 'Not provided') ?></td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!-- =====================================================
    MAIN CONTENT
    ====================================================== -->
    <main class="content-area">
        <div class="container-fluid">
            <!-- =================================================
            WELCOME
            ================================================== -->
            <div class="mb-4">
                <h4 class="fw-semibold mb-1">
                    Faculty Dashboard
                </h4>
                <p class="text-muted mb-0">
                    Review document submissions and verify user accounts.
                </p>
            </div>
            <!-- =================================================
            FEATURE CARDS
            ================================================== -->
            <div class="row g-4 mb-4">
                <!-- DOCUMENT SUBMISSIONS -->
                <div class="col-12 col-md-6">
                    <button
                        type="button"
                        id="documentButton"
                        class="feature-button"
                        onclick="showDocuments()"
                    >
                        <div class="feature-card">
                            <div class="card shadow-sm p-4">
                                <div class="d-flex align-items-center">
                                    <div class="feature-icon me-3">
                                        <i class="bi bi-file-earmark-check"></i>
                                    </div>
                                    <div>
                                        <h6 class="text-muted mb-1">
                                            Document Review
                                        </h6>
                                        <h4 class="mb-0 fw-semibold">
                                            Document Submissions
                                        </h4>
                                    </div>
                                    <div class="ms-auto">
                                        <span
                                            class="badge bg-warning text-dark"
                                            id="documentPendingCount"
                                        >
                                            0 Pending
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </button>
                </div>

                <!-- USER VERIFICATION -->
                <div class="col-12 col-md-6">
                    <button
                        type="button"
                        id="verificationButton"
                        class="feature-button"
                        onclick="showVerifications()"
                    >
                        <div class="feature-card">
                            <div class="card shadow-sm p-4">
                                <div class="d-flex align-items-center">
                                    <div class="feature-icon me-3">
                                        <i class="bi bi-person-check"></i>
                                    </div>
                                    <div>
                                        <h6 class="text-muted mb-1">
                                            Account Review
                                        </h6>
                                        <h4 class="mb-0 fw-semibold">
                                            User Verification
                                        </h4>
                                    </div>
                                    <div class="ms-auto">
                                        <span
                                            class="badge bg-warning text-dark"
                                            id="verificationPendingCount"
                                        >
                                            0 Pending
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </button>
                </div>
            </div>
            <!-- =================================================
            DYNAMIC CONTENT
            ================================================== -->
            <div id="sectionContent">
                <div class="card border-0 shadow-sm p-4">
                    <div class="text-center py-5">
                        <i
                            class="bi bi-person-workspace"
                            style="font-size: 3rem;"
                        ></i>
                        <h5 class="mt-3 fw-semibold">
                            Welcome, Faculty!
                        </h5>
                        <p class="text-muted mb-0">
                            Select a section above to review submissions
                            or verify users.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <!-- =====================================================
        FOOTER
    ====================================================== -->
    <footer
        class="bg-white border-top p-3 text-center text-muted small page-footer"
    >
        &copy; <?= date('Y') ?> SASS
    </footer>
    <!-- =====================================================
    DOCUMENT REVIEW MODAL
    ====================================================== -->
    <div
        class="modal fade"
        id="documentModal"
        tabindex="-1"
        aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="bi bi-file-earmark-text me-2"></i>
                        Document Review
                    </h5>
                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                    ></button>
                </div>
                <div class="modal-body">
                    <input
                        type="hidden"
                        id="documentId"
                    >
                    <div class="row g-4">
                        <!-- DOCUMENT INFORMATION -->
                        <div class="col-md-4">
                            <h6 class="fw-semibold mb-3">
                                Submission Information
                            </h6>
                            <div class="mb-3">
                                <div class="user-info-label">
                                    Student
                                </div>
                                <div
                                    class="user-info-value"
                                    id="documentStudent"
                                >
                                    -
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="user-info-label">
                                    Requirement
                                </div>
                                <div
                                    class="user-info-value"
                                    id="documentRequirement"
                                >
                                    -
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="user-info-label">
                                    File Name
                                </div>
                                <div
                                    class="user-info-value"
                                    id="documentFileName"
                                >
                                    -
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="user-info-label">
                                    Date Submitted
                                </div>
                                <div
                                    class="user-info-value"
                                    id="documentDate"
                                >
                                    -
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="user-info-label">
                                    Status
                                </div>
                                <span
                                    id="documentStatus"
                                    class="badge bg-warning text-dark"
                                >
                                    Pending
                                </span>
                            </div>
                        </div>
                        <!-- DOCUMENT PREVIEW -->
                        <div class="col-md-8">
                            <h6 class="fw-semibold mb-3">
                                Document Preview
                            </h6>
                            <iframe
                                id="documentPreview"
                                class="document-preview"
                                src=""
                            ></iframe>
                        </div>
                    </div>
                    <!-- DECLINE REMARK -->
                    <div
                        id="documentRemarkArea"
                        class="mt-4 d-none"
                    >
                        <label
                            for="documentRemark"
                            class="form-label fw-semibold"
                        >
                            Critic / Remark
                            <span class="text-danger">*</span>
                        </label>
                        <textarea
                            id="documentRemark"
                            class="form-control"
                            rows="4"
                            placeholder="Explain why this document is being declined..."
                        ></textarea>
                        <small class="text-muted">
                            A remark is required when declining a document.
                        </small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button
                        type="button"
                        class="btn btn-secondary"
                        data-bs-dismiss="modal"
                    >
                        Close
                    </button>
                    <button
                        type="button"
                        class="btn btn-danger"
                        onclick="declineDocument()"
                    >
                        <i class="bi bi-x-circle me-1"></i>
                        Decline
                    </button>
                    <button
                        type="button"
                        class="btn btn-success"
                        onclick="approveDocument()"
                    >
                        <i class="bi bi-check-circle me-1"></i>
                        Accept
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- =====================================================
    USER VERIFICATION MODAL
    ====================================================== -->

    <div
        class="modal fade"
        id="verificationModal"
        tabindex="-1"
        aria-hidden="true"
    >
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="bi bi-person-check me-2"></i>
                        User Verification
                    </h5>
                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                    ></button>
                </div>
                <div class="modal-body">
                    <input
                        type="hidden"
                        id="verificationId"
                    >
                    <!-- USER INFORMATION -->
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="user-info-label">
                                Login ID
                            </div>
                            <div
                                class="user-info-value"
                                id="verifyLoginId"
                            >
                                -
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="user-info-label">
                                Username
                            </div>
                            <div
                                class="user-info-value"
                                id="verifyUsername"
                            >
                                -
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="user-info-label">
                                Email
                            </div>
                            <div
                                class="user-info-value"
                                id="verifyEmail"
                            >
                                -
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="user-info-label">
                                Role
                            </div>
                            <div
                                class="user-info-value"
                                id="verifyRole"
                            >
                                -
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="user-info-label">Sex</div>
                            <div class="user-info-value" id="verifySex">-</div>
                        </div>
                        <div class="col-md-6">
                            <div class="user-info-label">Age</div>
                            <div class="user-info-value" id="verifyAge">-</div>
                        </div>
                        <div class="col-md-6">
                            <div class="user-info-label">Program</div>
                            <div class="user-info-value" id="verifyProgram">-</div>
                        </div>
                        <div class="col-md-6">
                            <div class="user-info-label">Year Level</div>
                            <div class="user-info-value" id="verifyYear">-</div>
                        </div>
                        <div class="col-md-6">
                            <div class="user-info-label">Contact</div>
                            <div class="user-info-value" id="verifyContact">-</div>
                        </div>
                        <div class="col-12">
                            <div class="user-info-label">Address</div>
                            <div class="user-info-value" id="verifyAddress">-</div>
                        </div>
                    </div>
                    <hr class="my-4">
                    <!-- VERIFICATION REMARK -->
                    <div
                        id="verificationRemarkArea"
                        class="mt-4"
                    >
                        <label
                            for="verificationRemark"
                            class="form-label fw-semibold"
                        >
                            Remark
                        </label>
                        <textarea
                            id="verificationRemark"
                            class="form-control"
                            rows="3"
                            placeholder="Optional remark..."
                        ></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button
                        type="button"
                        class="btn btn-secondary"
                        data-bs-dismiss="modal"
                    >
                        Close
                    </button>
                    <button
                        type="button"
                        class="btn btn-danger"
                        onclick="declineVerification()"
                    >
                        <i class="bi bi-person-x me-1"></i>
                        Decline
                    </button>
                    <button
                        type="button"
                        class="btn btn-success"
                        onclick="approveVerification()"
                    >
                        <i class="bi bi-person-check me-1"></i>
                        Verify User
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Bootstrap JS -->
<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
></script>
<script>

/* ============================================================
CSRF
============================================================ */
function csrfHeaders() {
    return {
        'X-CSRF-TOKEN':
            document
                .querySelector('meta[name="csrf-token"]')
                .content
    };

}

/* ============================================================
SHOW DOCUMENT SUBMISSIONS
============================================================ */

async function showDocuments() {
    const section =
        document.getElementById('sectionContent');
    document.getElementById('documentButton').disabled = true;
    document.getElementById('verificationButton').disabled = false;
    section.innerHTML = `
        <div class="card table-card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h5 class="fw-semibold mb-1">
                            Document Submissions
                        </h5>
                        <p class="text-muted mb-0">
                            Review documents submitted by users.
                        </p>
                    </div>
                    <button
                        class="btn btn-outline-primary"
                        onclick="showDocuments()"
                    >
                        <i class="bi bi-arrow-clockwise me-1"></i>
                        Refresh
                    </button>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Student</th>
                                <th>Requirement</th>
                                <th>File</th>
                                <th>Date Submitted</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="documentTableBody">
                            <tr>
                                <td
                                    colspan="6"
                                    class="text-center py-5"
                                >
                                    Loading documents...
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    `;
    try {
        const response = await fetch(
            '<?= site_url('faculty/requirements') ?>'
        );
        const result = await response.json();
        if (!response.ok || !result.success) {
            throw new Error(
                result.message ||
                'Unable to load documents.'
            );
        }
        renderDocuments(result.documents);
    }
    catch (error) {
        console.error(error);
        document.getElementById(
            'documentTableBody'
        ).innerHTML = `
            <tr>
                <td
                    colspan="6"
                    class="text-center text-danger py-5"
                >
                    Unable to load document submissions.
                </td>
            </tr>
        `;
    }
}


/* ============================================================
RENDER DOCUMENTS
============================================================ */

function renderDocuments(documents) {
    const body =
        document.getElementById('documentTableBody');
    body.replaceChildren();
    if (!documents || documents.length === 0) {
        body.innerHTML = `
            <tr>
                <td
                    colspan="6"
                    class="text-center text-muted py-5"
                >
                    No document submissions found.
                </td>
            </tr>
        `;
        return;
    }
    documents.forEach(document => {
        const row =
            document.createElement('tr');
        row.innerHTML = `
            <td>
                <div class="fw-semibold">
                    ${escapeHtml(document.userId)}
                </div>
            </td>
            <td>
                ${escapeHtml(document.fileRole)}
            </td>
            <td>
                <i class="bi bi-file-earmark-text me-1"></i>
                ${escapeHtml(document.fileName)}
            </td>
            <td>
                ${escapeHtml(document.upload_at)}
            </td>
            <td>
                ${statusBadge(document.fileStatus)}
            </td>
            <td>
                <button
                    type="button"
                    class="btn btn-sm btn-outline-primary"
                    onclick="openDocument(${document.id})"
                    title="View"
                >
                    <i class="bi bi-eye"></i>
                </button>
            </td>
        `;
        body.appendChild(row);
    });
}

/* ============================================================
OPEN DOCUMENT
============================================================ */

async function openDocument(id) {
    try {
        const response = await fetch(
            '<?= site_url('faculty/documents') ?>/' +
            encodeURIComponent(id)
        );
        const result = await response.json();
        if (!response.ok || !result.success) {
            throw new Error(
                result.message ||
                'Unable to load document.'
            );
        }
        const document = result.document;
        document.getElementById('documentId').value =
            document.id;
        document.getElementById('documentStudent').textContent =
            document.username;
        document.getElementById('documentRequirement').textContent =
            document.fileRole;
        document.getElementById('documentFileName').textContent =
            document.fileName;
        document.getElementById('documentDate').textContent =
            document.upload_at;
        const status =
            document.fileStatus || 'pending';
        document.getElementById('documentStatus').textContent =
            status;
        document.getElementById('documentStatus').className =
            'badge ' +
            statusClass(status);
        document.getElementById('documentPreview').src =
            '<?= site_url('documents') ?>/' +
            encodeURIComponent(document.id) +
            '/view';
        document.getElementById(
            'documentRemarkArea'
        ).classList.add('d-none');
        document.getElementById(
            'documentRemark'  
        ).value = '';
        const modal =
            new bootstrap.Modal(
                document.getElementById('documentModal')
            );
        modal.show();
    }
    catch (error) {
        console.error(error);
        alert(
            error.message ||
            'Unable to load document.'
        );
    }
}

/* ============================================================
APPROVE DOCUMENT
============================================================ */
async function approveDocument() {
    const id =
        document.getElementById('documentId').value;
    if (!id) return;
    if (!confirm(
        'Are you sure you want to accept this document?'
    )) {
        return;
    }
    await updateDocumentStatus(
        id,
        'approved',
        ''
    );
}

/* ============================================================
DECLINE DOCUMENT
============================================================ */

async function declineDocument() {
    const id =
        document.getElementById('documentId').value;
    const remark =
        document
            .getElementById('documentRemark')
            .value
            .trim();
    /*
    First click shows the remark field.
    */
    const remarkArea =
        document.getElementById(
            'documentRemarkArea'
        );
    if (remarkArea.classList.contains('d-none')) {
        remarkArea.classList.remove('d-none');
        document
            .getElementById('documentRemark')
            .focus();
        return;
    }
    /*
    Remark is REQUIRED when declining.
    */
    if (!remark) {
        alert(
            'Please provide a critic or remark before declining the document.'
        );
        document
            .getElementById('documentRemark')
            .focus();
        return;
    }
    if (!confirm(
        'Are you sure you want to decline this document?'
    )) {
        return;
    }
    await updateDocumentStatus(
        id,
        'declined',
        remark
    );
}


/* ============================================================
UPDATE DOCUMENT STATUS
============================================================ */

async function updateDocumentStatus(
    id,
    status,
    remark
) {
    try {
        const formData =
            new FormData();
        formData.append(
            'status',
            status
        );
        formData.append(
            'critic',
            remark
        );
        const response =
            await fetch(
                '<?= site_url('faculty/documents') ?>/' +
                encodeURIComponent(id) +
                '/review',
                {
                    method: 'POST',
                    headers: csrfHeaders(),
                    body: formData
                }
            );
        const result =
            await response.json();
        if (!response.ok || !result.success) {
            throw new Error(
                result.message ||
                'Unable to update document.'
            );
        }
        alert(result.message);
        const modalElement =
            document.getElementById(
                'documentModal'
            );
        const modal =
            bootstrap.Modal.getInstance(
                modalElement
            );
        if (modal) {
            modal.hide();
        }
        await showDocuments();
    }
    catch (error) {
        console.error(error);
        alert(
            error.message ||
            'Unable to update document.'
        );
    }
}


/* ============================================================
SHOW USER VERIFICATIONS
============================================================ */

async function showVerifications() {
    const section =
        document.getElementById('sectionContent');
    document.getElementById(
        'documentButton'
    ).disabled = false;
    document.getElementById(
        'verificationButton'
    ).disabled = true;
    section.innerHTML = `
        <div class="card table-card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h5 class="fw-semibold mb-1">
                            User Verification
                        </h5>
                        <p class="text-muted mb-0">
                            Review and verify user accounts.
                        </p>
                    </div>
                    <button
                        class="btn btn-outline-primary"
                        onclick="showVerifications()"
                    >
                        <i class="bi bi-arrow-clockwise me-1"></i>
                        Refresh
                    </button>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Login ID</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Date Submitted</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="verificationTableBody">
                            <tr>
                                <td
                                    colspan="7"
                                    class="text-center py-5"
                                >
                                    Loading users...
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    `;
    try {
        const response =
            await fetch(
                '<?= site_url('faculty/verifications') ?>'
            );
        const result =
            await response.json();
        if (!response.ok || !result.success) {
            throw new Error(
                result.message ||
                'Unable to load user verifications.'
            );
        }
        renderVerifications(
            result.users
        );
    }
    catch (error) {
        console.error(error);
        document.getElementById(
            'verificationTableBody'
        ).innerHTML = `
            <tr>
                <td
                    colspan="7"
                    class="text-center text-danger py-5"
                >
                    Unable to load user verifications.
                </td>
            </tr>
        `;
    }
}

/* ============================================================
RENDER VERIFICATIONS
============================================================ */

function renderVerifications(users) {
    const body =
        document.getElementById(
            'verificationTableBody'
        );
    body.replaceChildren();
    if (!users || users.length === 0) {
        body.innerHTML = `
            <tr>
                <td
                    colspan="7"
                    class="text-center text-muted py-5"
                >
                    No user verification requests found.
                </td>
            </tr>
        `;
        return;
    }
    users.forEach(user => {
        const row =
            document.createElement('tr');
        row.innerHTML = `
            <td>
                ${escapeHtml(user.login_id)}
            </td>
            <td class="fw-semibold">
                ${escapeHtml(user.username)}
            </td>
            <td>
                ${escapeHtml(user.email)}
            </td>
            <td>
                ${escapeHtml(user.role)}
            </td>
            <td>
                ${escapeHtml(user.created_at)}
            </td>
            <td>
                ${statusBadge(user.verification_status)}
            </td>
            <td>
                <button
                    type="button"
                    class="btn btn-sm btn-outline-primary"
                    onclick="openVerification(${user.id})"
                    title="Review User"
                >
                    <i class="bi bi-eye"></i>
                </button>
            </td>
        `;
        body.appendChild(row);
    });
}

/* ============================================================
OPEN USER VERIFICATION
============================================================ */

async function openVerification(id) {
    try {
        const response =
            await fetch(
                '<?= site_url('faculty/verifications') ?>/' +
                encodeURIComponent(id)
            );
        const result =
            await response.json();
        if (!response.ok || !result.success) {
            throw new Error(
                result.message ||
                'Unable to load user.'
            );
        }
        const user =
            result.user;
        document.getElementById(
            'verificationId'
        ).value = user.id;
        document.getElementById(
            'verifyLoginId'
        ).textContent =
            user.login_id || '-';
        document.getElementById(
            'verifyUsername'
        ).textContent =
            user.username || '-';
        document.getElementById(
            'verifyEmail'
        ).textContent =
            user.email || '-';
        document.getElementById(
            'verifyRole'
        ).textContent =
            user.role || '-';
        document.getElementById('verifySex').textContent = user.sex || '-';
        document.getElementById('verifyAge').textContent = user.age || '-';
        document.getElementById('verifyProgram').textContent = user.program || '-';
        document.getElementById('verifyYear').textContent = user.year || '-';
        document.getElementById('verifyContact').textContent = user.contact || '-';
        document.getElementById('verifyAddress').textContent = user.address || '-';
        document.getElementById(
            'verificationRemark'
        ).value = user.verification_remark || '';
        const modal =
            new bootstrap.Modal(
                document.getElementById(
                    'verificationModal'
                )
            );
        modal.show();
    }
    catch (error) {
        console.error(error);
        alert(
            error.message ||
            'Unable to load user verification.'
        );
    }
}


/* ============================================================
APPROVE USER
============================================================ */

async function approveVerification() {
    const id =
        document.getElementById(
            'verificationId'
        ).value;
    if (!id) return;
    if (!confirm(
        'Are you sure you want to verify this user?'
    )) {
        return;
    }
    await updateVerificationStatus(
        id,
        'approved'
    );
}


/* ============================================================
DECLINE USER
============================================================ */

async function declineVerification() {
    const id =
        document.getElementById(
            'verificationId'
        ).value;
    const remark =
        document.getElementById(
            'verificationRemark'
        ).value.trim();
    if (!remark) {
        alert(
            'Please provide a reason before declining this user.'
        );
        document
            .getElementById(
                'verificationRemark'
            )
            .focus();
        return;
    }
    if (!confirm(
        'Are you sure you want to decline this user verification?'
    )) {
        return;
    }
    await updateVerificationStatus(
        id,
        'declined',
        remark
    );
}

/* ============================================================
UPDATE USER VERIFICATION
============================================================ */

async function updateVerificationStatus(
    id,
    status,
    remark = ''
) {
    try {
        const formData =
            new FormData();
        formData.append(
            'status',
            status
        );
        formData.append(
            'remark',
            remark
        );
        const response =
            await fetch(
                '<?= site_url('faculty/verifications') ?>/' +
                encodeURIComponent(id) +
                '/review',
                {
                    method: 'POST',
                    headers: csrfHeaders(),
                    body: formData
                }
            );
        const result =
            await response.json();
        if (!response.ok || !result.success) {
            throw new Error(
                result.message ||
                'Unable to update verification.'
            );
        }
        alert(result.message);
        const modalElement =
            document.getElementById(
                'verificationModal'
            );
        const modal =
            bootstrap.Modal.getInstance(
                modalElement
            );
        if (modal) {
            modal.hide();
        }
        await showVerifications();
        await loadPendingCounts();
    }
    catch (error) {
        console.error(error);
        alert(
            error.message ||
            'Unable to update verification.'
        );
    }
}


/* ============================================================
STATUS BADGE
============================================================ */

function statusBadge(status) {
    status =
        String(status || 'Pending');
    return `
        <span class="status-badge ${statusClass(status)}">
            ${escapeHtml(status)}
        </span>
    `;
}


function statusClass(status) {
    switch (
        String(status).toLowerCase()
    ) {
        case 'approved':
        case 'verified':
            return 'bg-success text-white';
        case 'declined':
        case 'rejected':
            return 'bg-danger text-white';
        default:
            return 'bg-warning text-dark';
    }
}

/* ============================================================
ESCAPE HTML
============================================================ */
function escapeHtml(value) {
    if (value === null || value === undefined) {
        return '';
    }
    return String(value)
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;')
        .replace(/'/g, '&#039;');

}

/* ============================================================
LOAD COUNTS
============================================================ */

async function loadPendingCounts() {
    try {
        const response =
            await fetch(
                '<?= site_url('faculty/pending-counts') ?>'
            );
        const result =
            await response.json();
        if (!result.success) return;
        document.getElementById(
            'documentPendingCount'
        ).textContent =
            result.documents + ' Pending';
        document.getElementById(
            'verificationPendingCount'
        ).textContent =
            result.verifications + ' Pending';
        const documentCount = Number(result.documents) || 0;
        const verificationCount = Number(result.verifications) || 0;
        const totalCount = documentCount + verificationCount;
        document.getElementById('notificationDocumentCount').textContent = documentCount;
        document.getElementById('notificationVerificationCount').textContent = verificationCount;
        const totalBadge = document.getElementById('facultyNotificationTotal');
        totalBadge.textContent = totalCount;
        totalBadge.classList.toggle('d-none', totalCount === 0);
    }
    catch (error) {
        console.error(
            'Unable to load pending counts:',
            error
        );
    }
}

/* ============================================================
INITIALIZE
============================================================ */
document.addEventListener(
    'DOMContentLoaded',
    loadPendingCounts
);

</script>
</body>
</html>