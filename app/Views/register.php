<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Register</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <style>

        body {
            background-color: #3b185f;
            min-height: 100vh;

            display: flex;
            align-items: center;
            justify-content: center;

            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;

            position: relative;

            overflow: auto;

            padding: 30px 15px;
        }

        /* Background glow - top left */
        body::before {
            content: '';

            position: absolute;

            top: -100px;
            left: -100px;

            width: 300px;
            height: 300px;

            background: radial-gradient(
                circle,
                #ff007f 0%,
                rgba(255, 0, 127, 0) 70%
            );

            border-radius: 50%;
        }

        /* Background glow - bottom right */
        body::after {
            content: '';

            position: absolute;

            bottom: -100px;
            right: -100px;

            width: 350px;
            height: 350px;

            background: radial-gradient(
                circle,
                #ff007f 0%,
                rgba(255, 0, 127, 0) 70%
            );

            border-radius: 50%;
        }

        /* Main registration card */
        .login-wrapper {
            width: 100%;
            max-width: 1250px;

            background: #ffffff;

            border-radius: 20px;

            box-shadow:
                0 20px 40px rgba(0, 0, 0, 0.4);

            z-index: 1;
        }

        /* Form area */
        .login-form-side {
            padding: 3rem 4rem;
        }

        /* Title */
        .login-title {
            font-weight: 700;

            color: #1a1a1a;

            font-size: 2rem;
        }

        /* Subtitle */
        .login-subtitle {
            color: #8c8c8c;

            font-size: 0.95rem;
        }

        .login-subtitle a {
            color: #ff6b4a;

            text-decoration: none;
        }

        .login-subtitle a:hover {
            text-decoration: underline;
        }

        /* Form group */
        .form-group {
            margin-bottom: 1.5rem;
        }

        /* Input styling */
        .custom-input {
            border: none;

            border-bottom: 1px solid #e0e0e0;

            border-radius: 0;

            padding-left: 0;

            padding-bottom: 8px;

            color: #333;

            box-shadow: none !important;

            outline: none !important;
        }

        .custom-input:focus {
            border-color: #ff6b4a !important;

            box-shadow: none !important;
        }

        .custom-input::placeholder {
            color: #b0b0b0;
        }

        /* Select styling */
        select.custom-input {
            cursor: pointer;
        }

        /* Register button */
        .btn-gradient {
            background: linear-gradient(
                90deg,
                #ff9a3c,
                #ff4e00
            );

            border: none;

            color: #fff;

            border-radius: 50px;

            font-weight: 600;

            padding: 0.65rem 2.5rem;

            transition:
                opacity 0.2s,
                transform 0.2s;
        }

        .btn-gradient:hover {
            opacity: 0.95;

            color: #fff;

            transform: translateY(-1px);
        }

        /* Address field */
        .address-field {
            min-height: 42px;
        }

        /* Desktop */
        @media (min-width: 992px) {

            .login-wrapper {
                max-width: 1250px;
            }

            .login-form-side {
                padding: 3rem 4rem;
            }

        }

        /* Tablet */
        @media (max-width: 991px) {

            .login-wrapper {
                max-width: 850px;
            }

            .login-form-side {
                padding: 2.5rem;
            }

        }

        /* Mobile */
        @media (max-width: 767px) {

            body {
                padding: 20px 10px;
            }

            .login-wrapper {
                max-width: 600px;
            }

            .login-form-side {
                padding: 2rem 1.5rem;
            }

            .login-title {
                font-size: 1.7rem;
            }

        }

    </style>
</head>

<body>

<div class="container-fluid d-flex justify-content-center align-items-center">

    <!-- Registration Card -->
    <div class="login-wrapper">

        <div class="login-form-side">

            <!-- Title -->
            <h2 class="login-title mb-2">
                Register
            </h2>

            <!-- Error Message -->
            <?php if (session()->getFlashdata('error')): ?>

                <div class="alert alert-danger">
                    <?= session()->getFlashdata('error') ?>
                </div>

            <?php endif; ?>

            <!-- Description -->
            <p class="login-subtitle mb-4">

                Please enter your registration information
                or

                <a href="<?= site_url('login') ?>">
                    click here
                </a>

                to login.

            </p>


            <!-- ========================= -->
            <!-- REGISTRATION FORM -->
            <!-- ========================= -->

            <form
                action="<?= site_url('register') ?>"
                method="post"
            >

                <?= csrf_field() ?>


                <!-- ========================= -->
                <!-- ROW 1 -->
                <!-- User ID / Password / Role -->
                <!-- ========================= -->

                <div class="row">

                    <!-- User ID -->
                    <div class="col-md-4">

                        <div class="form-group">

                            <input
                                type="number"
                                id="loginId"
                                name="loginId"
                                class="form-control custom-input"
                                placeholder="User ID"
                                required
                            >

                        </div>

                    </div>


                    <!-- Password -->
                    <div class="col-md-4">

                        <div class="form-group">

                            <input
                                type="password"
                                id="password"
                                name="password"
                                class="form-control custom-input"
                                placeholder="Password"
                                required
                            >

                        </div>

                    </div>


                    <!-- Role -->
                    <div class="col-md-4">

                        <div class="form-group">

                            <select
                                id="role"
                                name="role"
                                class="form-control custom-input"
                                required
                            >

                                <option
                                    value=""
                                    selected
                                    disabled
                                >
                                    Role
                                </option>

                                <option value="Faculty">
                                    Faculty
                                </option>

                                <option value="Student">
                                    Student
                                </option>

                            </select>

                        </div>

                    </div>

                </div>


                <!-- ========================= -->
                <!-- ROW 2 -->
                <!-- Lastname / Firstname / Middlename -->
                <!-- ========================= -->

                <div class="row">

                    <!-- Lastname -->
                    <div class="col-md-4">

                        <div class="form-group">

                            <input
                                type="text"
                                id="lastname"
                                name="lastname"
                                class="form-control custom-input"
                                placeholder="Lastname"
                                required
                            >

                        </div>

                    </div>


                    <!-- Firstname -->
                    <div class="col-md-4">

                        <div class="form-group">

                            <input
                                type="text"
                                id="firstname"
                                name="firstname"
                                class="form-control custom-input"
                                placeholder="Firstname"
                                required
                            >

                        </div>

                    </div>


                    <!-- Middlename -->
                    <div class="col-md-4">

                        <div class="form-group">

                            <input
                                type="text"
                                id="middlename"
                                name="middlename"
                                class="form-control custom-input"
                                placeholder="Middlename"
                                required
                            >

                        </div>

                    </div>

                </div>


                <!-- ========================= -->
                <!-- ROW 3 -->
                <!-- Sex / Age / Email -->
                <!-- ========================= -->

                <div class="row">

                    <!-- Sex -->
                    <div class="col-md-4">

                        <div class="form-group">

                            <select
                                id="sex"
                                name="sex"
                                class="form-control custom-input"
                                required
                            >

                                <option
                                    value=""
                                    selected
                                    disabled
                                >
                                    Sex
                                </option>

                                <option value="Male">
                                    Male
                                </option>

                                <option value="Female">
                                    Female
                                </option>

                            </select>

                        </div>

                    </div>


                    <!-- Age -->
                    <div class="col-md-4">

                        <div class="form-group">

                            <input
                                type="number"
                                id="age"
                                name="age"
                                class="form-control custom-input"
                                placeholder="Age"
                                min="1"
                                max="100"
                                required
                            >

                        </div>

                    </div>


                    <!-- Email -->
                    <div class="col-md-4">

                        <div class="form-group">

                            <input
                                type="email"
                                id="email"
                                name="email"
                                class="form-control custom-input"
                                placeholder="Email"
                                required
                            >

                        </div>

                    </div>

                </div>


                <!-- ========================= -->
                <!-- ROW 4 -->
                <!-- Program / Year / Contact -->
                <!-- ========================= -->

                <div class="row">

                    <!-- Program -->
                    <div class="col-md-4">

                        <div class="form-group">

                            <select
                                id="program"
                                name="program"
                                class="form-control custom-input"
                                required
                            >

                                <option
                                    value=""
                                    selected
                                    disabled
                                >
                                    Program
                                </option>

                                <option value="BSIT">
                                    BSIT
                                </option>

                                <option value="BSInT">
                                    BSInT
                                </option>

                            </select>

                        </div>

                    </div>


                    <!-- Year -->
                    <div class="col-md-4">

                        <div class="form-group">

                            <select
                                id="year"
                                name="year"
                                class="form-control custom-input"
                                required
                            >

                                <option
                                    value=""
                                    selected
                                    disabled
                                >
                                    Year Level
                                </option>

                                <option value="1">
                                    First Year
                                </option>

                                <option value="2">
                                    Second Year
                                </option>

                                <option value="3">
                                    Third Year
                                </option>

                                <option value="4">
                                    Fourth Year
                                </option>

                            </select>

                        </div>

                    </div>


                    <!-- Contact -->
                    <div class="col-md-4">

                        <div class="form-group">

                            <input
                                type="text"
                                id="contact"
                                name="contact"
                                class="form-control custom-input"
                                placeholder="Contact Number"
                                required
                            >

                        </div>

                    </div>

                </div>


                <!-- ========================= -->
                <!-- ROW 5 -->
                <!-- Address / Register -->
                <!-- ========================= -->

                <div class="row align-items-end">

                    <!-- Address -->
                    <div class="col-md-8">

                        <div class="form-group">

                            <input
                                type="text"
                                id="address"
                                name="address"
                                class="form-control custom-input address-field"
                                placeholder="Address"
                                required
                            >

                        </div>

                    </div>


                    <!-- Register Button -->
                    <div class="col-md-4">

                        <div class="form-group">

                            <button
                                type="submit"
                                class="btn btn-gradient w-100"
                            >
                                Register
                            </button>

                        </div>

                    </div>

                </div>

            </form>

        </div>

    </div>

</div>


<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js">
</script>

</body>
</html>
