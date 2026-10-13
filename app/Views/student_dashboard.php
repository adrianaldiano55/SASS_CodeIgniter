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
    <title>SASS</title>
    <meta name="description" content="Student Assistant Submission System">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?= esc(csrf_hash()) ?>">
    <!-- Bootstrap 5 CSS -->
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

        /* Main Page Wrapper */
        .page-wrapper {
            min-height: 100vh;
            height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* Top Navbar */
        .top-navbar {
            height: 70px;
            flex-shrink: 0;
        }

        /* Main Content */
        .content-area {
            flex: 1;
            padding: 1.5rem;
            overflow-y: auto;
        }

        /* Navigation Icon Buttons */
        .nav-icon-btn {
            width: 42px;
            height: 42px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: none;
            background-color: #f8f9fa;
            color: #495057;
            transition: all 0.2s ease;
        }

        .nav-icon-btn:hover {
            background-color: #e9ecef;
            color: #0d6efd;
            transform: translateY(-1px);
        }

        .nav-icon-btn i {
            font-size: 1.25rem;
        }

        /* Feature Cards */
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
            transition: all 0.2s ease;
            cursor: pointer;
        }

        .feature-button:hover .feature-card {
            transform: translateY(-3px);
        }

        .feature-card .card {
            height: 100%;
            border: 0;
            transition: all 0.2s ease;
        }

        .feature-button:hover .card {
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.12) !important;
        }

        /* Disabled Feature */
        .feature-button:disabled {
            cursor: default;
        }

        .feature-button:disabled .feature-card {
            transform: none;
            opacity: 0.75;
        }

        .feature-button:disabled .card {
            background-color: #e9ecef;
            box-shadow: none !important;
        }

        .feature-button:disabled .feature-icon {
            background-color: #dee2e6;
            color: #6c757d;
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

        /* Section Content */
        .section-content {
            min-height: 300px;
        }

        /* Upload Buttons */
        .upload-option {
            border: 1px solid #dee2e6;
            border-radius: 10px;
            padding: 1rem;
            transition: all 0.2s ease;
        }

        .upload-option:hover {
            border-color: #0d6efd;
            background-color: #f8fbff;
        }

        .upload-option-icon {
            width: 45px;
            height: 45px;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #e7f1ff;
            color: #0d6efd;
            border-radius: 10px;
            font-size: 1.25rem;
        }

        /* Status Badges */
        .status-badge {
            padding: 0.45rem 0.75rem;
            border-radius: 50px;
            font-size: 0.8rem;
            font-weight: 500;
        }

        /* Footer */
        .page-footer {
            flex-shrink: 0;
        }

        /* Mobile */
        @media (max-width: 767.98px) {

            .top-navbar {
                height: auto;
                min-height: 65px;
            }

            .content-area {
                padding: 1rem;
            }

            .navbar-brand {
                font-size: 0.95rem !important;
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

    <!-- =========================
        TOP NAVBAR
    ========================== -->
    <header class="navbar navbar-expand-lg navbar-light bg-white border-bottom top-navbar px-3">
        <div class="container-fluid">
            <!-- System Name -->
            <span class="navbar-brand mb-0 h1 fs-5">
                Student Assistant Submission System
            </span>
            <!-- Right Side Buttons -->
            <div class="ms-auto d-flex align-items-center gap-2">
                <!-- Student notifications dropdown -->
                <div class="dropdown">
                    <button type="button" class="btn nav-icon-btn rounded-circle position-relative"
                            id="studentNotificationsDropdown" data-bs-toggle="dropdown"
                            aria-expanded="false" title="Notifications" aria-label="Notifications">
                        <i class="bi bi-bell"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end notification-dropdown shadow"
                        aria-labelledby="studentNotificationsDropdown">
                        <div class="notification-dropdown-title d-flex justify-content-between align-items-center">
                            <span>Notifications</span><span class="badge bg-primary">Updates</span>
                        </div>
                        <div class="notification-item">
                            <div class="notification-item-icon"><i class="bi bi-file-earmark-check"></i></div>
                            <div class="flex-grow-1">
                                <div class="fw-semibold small">Submission Update</div>
                                <div class="text-muted small">Check the status of your documents.</div>
                            </div>
                            <button type="button" class="btn btn-sm btn-outline-primary"
                                    data-bs-dismiss="dropdown" onclick="openSubmissionUpdates()">View</button>
                        </div>
                        <div class="notification-item">
                            <div class="notification-item-icon"><i class="bi bi-megaphone"></i></div>
                            <div class="flex-grow-1">
                                <div class="fw-semibold small">Announcements</div>
                                <div class="text-muted small">Announcement updates are not connected yet.</div>
                            </div>
                            <button type="button" class="btn btn-sm btn-outline-secondary" onclick="showAnnouncementsNotice()">View</button>
                        </div>
                    </div>
                </div>
                <!-- Profile details dropdown -->
                <div class="dropdown">
                    <button
                        type="button"
                        class="btn nav-icon-btn rounded-circle"
                        id="studentProfileDropdown"
                        data-bs-toggle="dropdown"
                        aria-expanded="false"
                        title="View profile details"
                        aria-label="View profile details">
                        <i class="bi bi-person-circle"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end profile-dropdown p-0 shadow"
                        aria-labelledby="studentProfileDropdown">
                        <div class="profile-dropdown-header">
                            <div class="profile-avatar"><i class="bi bi-person-fill"></i></div>
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
                            <div class="profile-detail-row"><span>Program</span><strong><?= esc($userProfile['program'] ?? 'Not provided') ?></strong></div>
                            <div class="profile-detail-row"><span>Year Level</span><strong><?= esc($userProfile['year'] ?? 'Not provided') ?></strong></div>
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
    <!-- =========================
        MAIN CONTENT
    ========================== -->
    <main class="content-area">
        <div class="container-fluid">
            <!-- =========================
                FEATURE BUTTONS
            ========================== -->
            <div class="row g-4 mb-4">
                <!-- =========================
                    UPLOAD REQUIREMENTS
                ========================== -->
                <div class="col-12 col-md-6">
                    <button type="button"
                            id="uploadRequirementsBtn"
                            class="feature-button"
                            onclick="showUploadSection()">
                        <div class="feature-card">
                            <div class="card shadow-sm p-4">
                                <div class="d-flex align-items-center">
                                    <div class="feature-icon me-3">
                                        <i class="bi bi-cloud-arrow-up"></i>
                                    </div>
                                    <div>
                                        <h6 class="text-muted mb-1">
                                            Upload Requirements
                                        </h6>
                                        <h4 class="mb-0 fw-semibold">
                                            Submit Documents
                                        </h4>
                                    </div>
                                    <div class="ms-auto">
                                        <i class="bi bi-chevron-right text-muted"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </button>
                </div>
                <!-- =========================
                    DOCUMENT STATUS
                ========================== -->
                <div class="col-12 col-md-6">
                    <button type="button"
                            id="documentStatusBtn"
                            class="feature-button"
                            onclick="showStatusSection()">
                        <div class="feature-card">
                            <div class="card shadow-sm p-4">
                                <div class="d-flex align-items-center">
                                    <div class="feature-icon me-3">
                                        <i class="bi bi-file-earmark-check"></i>
                                    </div>
                                    <div>
                                        <h6 class="text-muted mb-1">
                                            Document Status
                                        </h6>
                                        <h4 class="mb-0 fw-semibold">
                                            Check Submissions
                                        </h4>
                                    </div>
                                    <div class="ms-auto">
                                        <i class="bi bi-chevron-right text-muted"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </button>
                </div>
            </div>
            <!-- =========================
                DYNAMIC SECTION
            ========================== -->
            <div id="sectionContent">
                <!-- Default Welcome Section -->
                <div class="card border-0 shadow-sm p-4 section-content">
                    <h5 class="card-title fw-semibold">
                        Welcome, Student!
                    </h5>
                    <p class="text-muted">
                        Manage your requirements, upload documents,
                        and check the status of your submissions
                        using the options above.
                    </p>
                </div>
            </div>
        </div>
    </main>
    <!-- =========================
        FOOTER
    ========================== -->
    <footer class="bg-white border-top p-3 text-center text-muted small page-footer">
        &copy; <?= date('Y') ?> SASS
    </footer>

        <!-- EDIT DOCUMENT MODAL -->
    <div
        class="modal fade"
        id="editDocumentModal"
        tabindex="-1"
        aria-labelledby="editDocumentModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5
                        class="modal-title"
                        id="editDocumentModalLabel">
                        <i class="bi bi-pencil-square me-2"></i>
                        Edit Document
                    </h5>
                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal">
                    </button>
                </div>
                <div class="modal-body">
                    <input
                        type="hidden"
                        id="editFileId">
                    <div class="mb-3">
                        <label class="form-label">
                            Requirement
                        </label>
                        <input
                            type="text"
                            id="editFileRole"
                            class="form-control"
                            readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">
                            Current File
                        </label>
                        <input
                            type="text"
                            id="editCurrentFile"
                            class="form-control"
                            readonly>
                    </div>
                    <div class="mb-3">
                        <label
                            for="editFile"
                            class="form-label">
                            Select New File
                        </label>
                        <input
                            type="file"
                            id="editFile"
                            class="form-control"
                            accept=".pdf,.doc,.docx,.jpg,.jpeg,.png"
                            required>
                        <small class="text-muted">
                            Selecting a new file will replace the
                            current document.
                        </small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button
                        type="button"
                        class="btn btn-secondary"
                        data-bs-dismiss="modal">
                        Cancel
                    </button>
                    <button
                        type="button"
                        class="btn btn-primary"
                        onclick="updateDocument()">
                        <i class="bi bi-save me-1"></i>
                        Update Document
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Bootstrap 5 JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function openSubmissionUpdates() {
        showStatusSection();
    }

    function showAnnouncementsNotice() {
        alert('Announcements are not connected yet. This button can be linked when the announcement feature is implemented.');
    }
    /*
    ============================================================
        SHOW UPLOAD REQUIREMENTS
    ============================================================
    */
    function showUploadSection() {
        const uploadButton =
            document.getElementById('uploadRequirementsBtn');
        const statusButton =
            document.getElementById('documentStatusBtn');
        const section =
            document.getElementById('sectionContent');
        const requirements = [
            'DSWD Certificate',
            'SAP Form 1',
            'SAP Form 2',
            '2pc. 1x1 ID Picture',
            'Photocopy of School ID Back to Back',
            'Photocopy of School Enrollment',
            'Grades from 1st Year to Current Year',
            'SAP Form 3',
            'Medical Certificate'
        ];

        uploadButton.disabled = true;
        statusButton.disabled = false;
        section.innerHTML = `
            <div class="card border-0 shadow-sm p-4 section-content">
                <div class="d-flex align-items-center mb-4">
                    <div class="feature-icon me-3">
                        <i class="bi bi-cloud-arrow-up"></i>
                    </div>
                    <div>
                        <h5 class="mb-1 fw-semibold">
                            Upload Requirements
                        </h5>
                        <p class="text-muted mb-0">
                            Upload the required documents below.
                        </p>
                    </div>
                </div>
                <div class="row g-3">
                    ${requirements.map((requirement, index) => `
                        <div class="col-12 col-lg-6">
                            <div class="upload-option">
                                <form onsubmit='uploadFile(event, ${JSON.stringify(requirement)}, "requirementFile${index}")'>
                                    <div class="d-flex align-items-center">
                                        <div class="upload-option-icon me-3">
                                            <i class="bi bi-file-earmark-pdf"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <h6 class="mb-1">${requirement}</h6>
                                            <small class="text-muted">Upload a PDF file.</small>
                                            <input
                                                type="file"
                                                id="requirementFile${index}"
                                                class="form-control form-control-sm mt-2"
                                                accept=".pdf,application/pdf"
                                                required
                                            >
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-sm mt-3">
                                        <i class="bi bi-upload me-1"></i>
                                        Submit
                                    </button>
                                </form>
                            </div>
                        </div>
                    `).join('')}
                </div>
            </div>
        `;
    }
    /*
    ============================================================
        SHOW DOCUMENT STATUS
    ============================================================
    */
    async function showStatusSection() {
        const uploadButton =
            document.getElementById('uploadRequirementsBtn');
        const statusButton =
            document.getElementById('documentStatusBtn');
        const section =
            document.getElementById('sectionContent');
        // Enable Upload button
        uploadButton.disabled = false;
        // Disable Document Status button
        statusButton.disabled = true;
        // Replace section content
        section.innerHTML = `
            <div class="section-content">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h3 class="mb-1">Document Status</h3>
                        <p class="text-muted mb-0">
                            View the status of your submitted requirements.
                        </p>
                    </div>
                    <button
                        type="button"
                        class="btn btn-outline-primary"
                        onclick="showUploadSection()">
                        <i class="bi bi-upload me-1"></i>
                        Upload Requirements
                    </button>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Requirement</th>
                                <th>File</th>
                                <th>Date Submitted</th>
                                <th>Status</th>
                                <th>Remarks</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="documentStatusTableBody">
                            <tr>
                                <td colspan="6" class="text-center">Loading documents...</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
                    `;
        try {
            const response = await fetch('<?= site_url('documents/status') ?>');
            const result = await response.json();
            if (!response.ok || !result.success) {
                throw new Error(result.message || 'Unable to load document statuses.');
            }
            renderDocumentStatus(result.files);
        } catch (error) {
            console.error(error);
            const tableBody = document.getElementById('documentStatusTableBody');
            if (tableBody) {
                tableBody.innerHTML = '<tr><td colspan="6" class="text-center text-danger">Unable to load documents. Please try again.</td></tr>';
            }
        }
    }

    function renderDocumentStatus(files) {
        const tableBody = document.getElementById('documentStatusTableBody');
        tableBody.replaceChildren();
        if (!files.length) {
            const row = document.createElement('tr');
            const cell = document.createElement('td');
            cell.colSpan = 6;
            cell.className = 'text-center py-5';
            cell.textContent = 'No documents submitted yet.';
            row.appendChild(cell);
            tableBody.appendChild(row);
            return;
        }
        files.forEach((file) => {
            const row = document.createElement('tr');
            const requirement = document.createElement('td');
            requirement.textContent = file.fileRole;
            row.appendChild(requirement);
            const fileName = document.createElement('td');
            fileName.textContent = file.fileName;
            row.appendChild(fileName);
            const uploadDate = document.createElement('td');
            uploadDate.textContent = file.upload_at;
            row.appendChild(uploadDate);
            const statusCell = document.createElement('td');
            const badge = document.createElement('span');
            const status = String(file.fileStatus || 'Pending');
            badge.className = 'badge ' + (
                status.toLowerCase() === 'approved'
                    ? 'bg-success'
                    : status.toLowerCase() === 'rejected'
                        ? 'bg-danger'
                        : 'bg-warning text-dark'
            );
            badge.textContent = status;
            statusCell.appendChild(badge);
            row.appendChild(statusCell);
            const remarkCell = document.createElement('td');
            if (file.critic) {
                const remarkButton = document.createElement('button');
                remarkButton.type = 'button';
                remarkButton.className = 'btn btn-sm btn-outline-secondary';
                remarkButton.textContent = 'View Remark';
                remarkButton.addEventListener('click', () => showRemark(file.critic));
                remarkCell.appendChild(remarkButton);
            } else {
                remarkCell.textContent = 'No remarks';
                remarkCell.className = 'text-muted';
            }
            row.appendChild(remarkCell);
            const actions = document.createElement('td');
            const buttonGroup = document.createElement('div');
            buttonGroup.className = 'btn-group';
            buttonGroup.appendChild(createActionButton('View document', 'btn-outline-primary', 'bi-eye', () => viewDocument(file.id)));
            buttonGroup.appendChild(createActionButton('Edit document', 'btn-outline-warning', 'bi-pencil', () => editDocument(file.id, file.fileRole, file.fileName)));
            buttonGroup.appendChild(createActionButton('Delete document', 'btn-outline-danger', 'bi-trash', () => deleteDocument(file.id)));
            actions.appendChild(buttonGroup);
            row.appendChild(actions);
            tableBody.appendChild(row);
        });
    }

    function createActionButton(title, styleClass, iconClass, action) {
        const button = document.createElement('button');
        button.type = 'button';
        button.className = 'btn btn-sm ' + styleClass;
        button.title = title;
        button.setAttribute('aria-label', title);
        const icon = document.createElement('i');
        icon.className = 'bi ' + iconClass;
        button.appendChild(icon);
        button.addEventListener('click', action);
        return button;
    }

    function csrfHeaders() {
        return {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        };
    }

    function showRemark(remark) {
        alert(remark);
    }

    function viewDocument(id) {
        window.open('<?= site_url('documents') ?>/' + encodeURIComponent(id) + '/view', '_blank', 'noopener');
    }

    async function uploadFile(event, requirementName, inputId) {
        event.preventDefault();
        const fileInput = document.getElementById(inputId);
        const file = fileInput.files[0];
        if (!file) {
            alert('Please select a file first.');
            return;
        }
        // Maximum file size: 15 MB
        const maxSize = 15 * 1024 * 1024;
        if (file.size > maxSize) {
            alert('File is too large. Maximum size is 15 MB.');
            return;
        }
        const formData = new FormData();
        formData.append('fileRole', requirementName);
        formData.append('document', file);
        try {
            const response = await fetch('<?= site_url('documents') ?>', {
                method: 'POST',
                headers: csrfHeaders(),
                body: formData
            });
            const result = await response.json();
            if (!response.ok || !result.success) {
                throw new Error(result.message || 'File upload failed.');
            }
            alert(result.message);
            fileInput.value = '';
            await showStatusSection();
        } catch (error) {
            console.error(error);
            alert(error.message || 'An error occurred while uploading the file.');
        }
    }

    async function deleteDocument(id) {
        const confirmed = confirm(
            'Are you sure you want to delete this document?\n\n' +
            'This action cannot be undone.'
        );
        if (!confirmed) {
            return;
        }
        try {
            const response = await fetch('<?= site_url('documents') ?>/' + encodeURIComponent(id) + '/delete', {
                method: 'POST',
                headers: csrfHeaders()
            });
            const result = await response.json();
            if (!response.ok || !result.success) {
                throw new Error(result.message || 'Unable to delete the document.');
            }
            alert(result.message);
            await showStatusSection();
        } catch (error) {
            console.error(error);
            alert(error.message || 'An error occurred while deleting the document.');
        }
    }

    function editDocument(id, fileRole, fileName) {
        document.getElementById('editFileId').value = id;
        document.getElementById('editFileRole').value = fileRole;
        document.getElementById('editCurrentFile').value = fileName;
        document.getElementById('editFile').value = '';
        const modalElement =
            document.getElementById('editDocumentModal');
        const modal =
            new bootstrap.Modal(modalElement);
        modal.show();
    }

    async function updateDocument() {
    const id =
        document.getElementById('editFileId').value;
    const fileInput =
        document.getElementById('editFile');
    const file = fileInput.files[0];
    if (!file) {
        alert('Please select a new file.');
        return;
    }
    // 16 MB limit
    const maxSize = 15 * 1024 * 1024;
    if (file.size > maxSize) {
        alert('File is too large. Maximum size is 15 MB.');
        return;
    }
    const formData = new FormData();
    formData.append('document', file);
    try {
        const response = await fetch('<?= site_url('documents') ?>/' + encodeURIComponent(id) + '/update', {
            method: 'POST',
            headers: csrfHeaders(),
            body: formData
        });
        const result = await response.json();
        if (!response.ok || !result.success) {
            throw new Error(result.message || 'Unable to update document.');
        }
        alert(result.message);
        const modalElement = document.getElementById('editDocumentModal');
        const modal = bootstrap.Modal.getInstance(modalElement);
        if (modal) {
            modal.hide();
        }
        await showStatusSection();
    } catch (error) {
        console.error(error);
        alert(error.message || 'An error occurred while updating the document.');
    }
}


</script>
</body>
</html>