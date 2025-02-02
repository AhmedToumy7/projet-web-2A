<?php
include_once '../../controller/jobPostC.php';
include_once '../../controller/jobFieldC.php';

$jobPostC = new JobPostC();
$jobFieldC = new jobFieldC();

session_start();

$sort = isset($_GET['sort']) ? $_GET['sort'] : null;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titlePattern = "/^[a-zA-Z0-9\s]{1,30}$/";
    $locationPattern = "/^[a-zA-Z0-9\s]{1,30}$/";
    $salaryPattern = "/^[0-9,]+(\$|TND)$/"; //TODO: make it only numbers
    $descriptionPattern = "/^[a-zA-Z0-9\s,;:!?@#$%&*()-+=\[\]{}|<>.\'\"]{1,1000}$/";

    $title = $_POST['job-titleT'];
    $location = $_POST['job-locationT'];
    $salary = $_POST['job-salaryT'];
    $description = $_POST['descriptionT'];

    if (!preg_match($titlePattern, $title) || !preg_match($locationPattern, $location) || !preg_match($salaryPattern, $salary) || !preg_match($descriptionPattern, $description)) {
        echo "Data Error";
    } else {
        $current_date = date('Y-m-d H:i:s');
        $id = null;

        $jobPost = new JobPost(
            $_POST['id'] = $id,
            $title,
            $_POST['company_name'] = "login company",
            $location,
            $_POST['date'] = $current_date,
            $salary,
            $_POST['status'] = "1",
            $_POST['fieldsT'],
            $_POST['job-levelT'],
            $_POST['job-typeT'],
            $description
        );
        $jobPostC->addJobPost($jobPost);
        header('Location: job-listings.php');
        exit;
    }
}
//SEARCH
$list = [];
if (isset($_GET['search'])) {
    if (!empty($_GET['job-fieldS'])) {
        $fieldS = $_GET['job-fieldS'];
        $list = array_merge($list, $jobPostC->searchJobPostByFieldId($fieldS));
    }
    if (!empty($_GET['job-levelS'])) {
        $levelS = $_GET['job-levelS'];
        $list = array_merge($list, $jobPostC->searchJobPostByLevelId($levelS));
    }
    if (!empty($_GET['job-typeS'])) {
        $typeS = $_GET['job-typeS'];
        $list = array_merge($list, $jobPostC->searchJobPostByEmploymentTypeId($typeS));
    }
    if (!empty($_GET['job-titleS'])) {
        $titleS = $_GET['job-titleS'];
        $list = array_merge($list, $jobPostC->searchJobPostByTitle($titleS));
    }
    if (!empty($_GET['job-salaryS'])) {
        $salaryS = $_GET['job-salaryS'];
        $list = array_merge($list, $jobPostC->searchJobPostBySalary($salaryS));
    }
    if (!empty($_GET['job-locationS'])) {
        $locationS = $_GET['job-locationS'];
        $list = array_merge($list, $jobPostC->searchJobPostByLocation($locationS));
    }
    if (!empty($_GET['fieldsS'])) {
        $fieldsS = $_GET['fieldsS'];
        $list = array_merge($list, $jobPostC->searchJobPostByFieldId($fieldsS));
    }
    $list = array_unique($list, SORT_REGULAR);
    $_SESSION['searchQuery'] = $list;
} else if (isset($_SESSION['searchQuery'])) {
    // If there's no new search query but there's a saved one in the session, use that
    $list = $_SESSION['searchQuery'];
} else {
    $list = $jobPostC->listJobPosts();
    if ($list instanceof PDOStatement) {
        $list = $list->fetchAll(PDO::FETCH_ASSOC);
    }
}
if (isset($_POST['reset'])) {
    unset($_SESSION['searchQuery']);
}
// Sorting
switch ($sort) {
    case 'latest':
        usort($list, function ($a, $b) {
            return strtotime($b['PostingDate']) - strtotime($a['PostingDate']);
        });
        break;
    case 'salary':
        usort($list, function ($a, $b) {
            return (int)$b['Salary'] - (int)$a['Salary'];
        });
        break;
}

$totalJobs = count($list);
$topFields = $jobFieldC->getTopFields();

?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="description" content="">
    <meta name="author" content="">

    <title>Gotto Job Listing</title>

    <!-- CSS FILES -->
    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=League+Spartan:wght@100;300;400;600;700&display=swap" rel="stylesheet">

    <link href="css/bootstrap.min.css" rel="stylesheet">

    <link href="css/bootstrap-icons.css" rel="stylesheet">

    <link href="css/owl.carousel.min.css" rel="stylesheet">

    <link href="css/owl.theme.default.min.css" rel="stylesheet">

    <link href="css/tooplate-gotto-job.css" rel="stylesheet">

    <!--

Tooplate 2134 Gotto Job

https://www.tooplate.com/view/2134-gotto-job

Bootstrap 5 HTML CSS Template

-->

</head>

<body class="job-listings-page" id="top">

    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="index.php">
                <img src="images/logo.png" class="img-fluid logo-image">

                <div class="d-flex flex-column">
                    <a class="logo-text">5ademni</a>
                </div>
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav align-items-center ms-lg-5">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Homepage</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="about.html">About Gotto</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="job-listings.php">Jobs</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="contact.html">Contact</a>
                    </li>

                    <li class="nav-item ms-lg-auto">
                        <a class="nav-link" href="#">Register</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link custom-btn btn" href="#">Login</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <main>

        <header class="site-header">
            <div class="section-overlay"></div>

            <div class="container">
                <div class="row">

                    <div class="col-lg-12 col-12 text-center">
                        <h1 class="text-white">Job Listings</h1>

                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb justify-content-center">
                                <li class="breadcrumb-item"><a href="index.php">Home</a></li>

                                <li class="breadcrumb-item active" aria-current="page">Job listings</li>
                            </ol>
                        </nav>
                    </div>

                </div>
            </div>
        </header>
        <?php
        //MARK: job search
        //S is for search
        ?>
        <section class="section-padding pb-0 d-flex justify-content-center align-items-center">
            <div class="container">
                <div class="row">

                    <div class="col-lg-12 col-12">
                        <form class="custom-form hero-form" action="#" method="get" role="form">
                            <h3 class="text-white mb-3">Search your dream job</h3>

                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-12">
                                    <div class="input-group">
                                        <span class="input-group-text" id="basic-addon1"><i class="bi-cash custom-icon"></i></span>
                                        <input type="text" class="form-control" name="job-salaryS" id="salaryS" placeholder="Enter Salary">
                                    </div>
                                </div>

                                <div class="col-lg-6 col-md-6 col-12">
                                    <div class="input-group">
                                        <span class="input-group-text" id="basic-addon1"><i class="bi-geo-alt custom-icon"></i></span>

                                        <input type="text" name="job-locationS" id="job-location" class="form-control" placeholder="Location">
                                    </div>
                                </div>

                                <div class="col-lg-4 col-md-4 col-12">
                                    <div class="input-group">
                                        <span class="input-group-text" id="basic-addon1"><i class="bi-laptop custom-icon"></i></span>

                                        <select class="form-select form-control" name="job-levelS" id="job-level" aria-label="Default select example">
                                            <option selected>Level</option>
                                            <option value="1">Internship</option>
                                            <option value="2">Junior</option>
                                            <option value="3">Senior</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-4 col-md-4 col-12">
                                    <div class="input-group">
                                        <span class="input-group-text" id="basic-addon1"><i class="bi-laptop custom-icon"></i></span>

                                        <select class="form-select form-control" name="job-typeS" id="job-type" aria-label="Default select example">
                                            <option selected>Type</option>
                                            <option value="1">Full Time</option>
                                            <option value="2">Part Time</option>
                                            <option value="3">Contract</option>
                                            <option value="4">Freelance</option>
                                            <option value="5">Remote</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-4 col-md-4 col-12">
                                    <div class="input-group">
                                        <span class="input-group-text" id="basic-addon1"><i class="bi-briefcase custom-icon create-icon"></i></span>
                                        <select class="form-select form-control" name="fieldsS" id="fieldsT" aria-label="Default select example">
                                            <option selected>field</option>
                                            <?php
                                            $fieldlist = $jobFieldC->listJobFields();

                                            foreach ($fieldlist as $field) {
                                                echo '<option value="' . $field['FieldID'] . '">' . $field['FieldName'] . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-12 col-12">
                                    <button type="submit" class="form-control" name="search">
                                        Search job
                                    </button>
                                    <button type="submit" class="form-control" name="reset">
                                        Reset Filter
                                    </button>
                                </div>

                                <div class="col-12">
                                    <div class="d-flex flex-wrap align-items-center mt-4 mt-lg-0">
                                        <span class="text-white mb-lg-0 mb-md-0 me-2">Popular fields:</span>

                                        <div>
                                            <?php
                                            for ($i = 0; $i < min(3, count($topFields)); $i++) {
                                                echo '<a href="job-listings.html" class="badge">' . $topFields[$i]['FieldName'] . '</a>';
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="col-lg-6 col-12">
                        <img src="images/4557388.png" class="hero-image img-fluid" alt="">
                    </div>

                </div>
            </div>
        </section>


        <section class="pb-0 d-flex justify-content-center align-items-center">
            <div class="container">
                <div class="row">

                    <?php
                    //MARK: job post
                    //T is from talent
                    ?>
                    <div class="col-lg-12 col-12">
                        <form class="custom-form hero-form create-form" action="#" method="post" role="form" id="jobform">
                            <h3 class="text-white mb-3">Search for talent</h3>

                            <div class="row">
                                <div class="col-lg-4 col-md-4 col-12">
                                    <div class="input-group">
                                        <span class="input-group-text" id="basic-addon1"><i class="bi-person custom-icon create-icon"></i></span>
                                        <input type="text" name="job-titleT" id="title" class="form-control" placeholder="Job Title">
                                    </div>
                                </div>

                                <div class="col-lg-4 col-md-4 col-12">
                                    <div class="input-group">
                                        <span class="input-group-text" id="basic-addon1"><i class="bi-geo-alt custom-icon create-icon"></i></span>
                                        <input type="text" name="job-locationT" id="location" class="form-control" placeholder="Location">
                                    </div>
                                </div>

                                <div class="col-lg-4 col-md-4 col-12">
                                    <div class="input-group">
                                        <span class="input-group-text" id="basic-addon1"><i class="bi-briefcase custom-icon create-icon"></i></span>
                                        <select class="form-select form-control" name="fieldsT" id="fieldsT" aria-label="Default select example">
                                            <option selected>field</option>
                                            <?php
                                            $fieldlist = $jobFieldC->listJobFields();

                                            foreach ($fieldlist as $field) {
                                                echo '<option value="' . $field['FieldID'] . '">' . $field['FieldName'] . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-4 col-md-4 col-12">
                                    <div class="input-group">
                                        <span class="input-group-text" id="basic-addon1"><i class="bi-cash custom-icon create-icon"></i></span>
                                        <input type="text" class="form-control" name="job-salaryT" id="salary" placeholder="Enter Salary">
                                    </div>
                                </div>

                                <div class="col-lg-4 col-md-4 col-12">
                                    <div class="input-group">
                                        <span class="input-group-text" id="basic-addon1"><i class="bi-laptop custom-icon create-icon"></i></span>
                                        <select class="form-select form-control" name="job-levelT" id="job-levelT" aria-label="Default select example">
                                            <option selected>Level</option>
                                            <option value="1">Internship</option>
                                            <option value="2">Junior</option>
                                            <option value="3">Senior</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-4 col-md-4 col-12">
                                    <div class="input-group">
                                        <span class="input-group-text" id="basic-addon1"><i class="bi-laptop custom-icon create-icon"></i></span>
                                        <select class="form-select form-control" name="job-typeT" id="job-typeT" aria-label="Default select example">
                                            <option selected>Type</option>
                                            <option value="1">Full Time</option>
                                            <option value="2">Part Time</option>
                                            <option value="3">Contract</option>
                                            <option value="4">Freelance</option>
                                            <option value="5">Remote</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-12 col-12">
                                    <div class="input-group">
                                        <span class="input-group-text" id="basic-addon1"><i class="bi-file-richtext custom-icon create-icon"></i></span>
                                        <input type="text" name="descriptionT" id="description" class="form-control" placeholder="Description">
                                    </div>
                                </div>

                                <div class="col-lg-12 col-12">
                                    <button type="submit" class="form-control create-button">
                                        Post job
                                    </button>
                                </div>

                            </div>
                        </form>
                    </div>


                    <div class="col-lg-6 col-12">
                        <img src="images/4557388.png" class="hero-image img-fluid" alt="">
                    </div>

                </div>
            </div>
        </section>


        <section class="job-section section-padding">
            <div class="container">
                <div class="row align-items-center">

                    <div class="col-lg-6 col-12 mb-lg-4">
                        <h3>Results of <?php echo $totalJobs; ?> jobs</h3>
                    </div>

                    <div class="col-lg-4 col-12 d-flex align-items-center ms-auto mb-5 mb-lg-4">
                        <p class="mb-0 ms-lg-auto">Sort by:</p>
                        <?php
                        //TODO:fix each sort to render when pressing it despite the redirection
                        ?>

                        <div class="dropdown dropdown-sorting ms-3 me-4">
                            <?php
                            $sort = $_GET['sort'] ?? '';
                            $buttonText = 'Select Filter';
                            if ($sort === 'latest') {
                                $buttonText = 'Latest Jobs';
                            } elseif ($sort === 'salary') {
                                $buttonText = 'Highest Salary Jobs';
                            }
                            ?>
                            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownSortingButton" data-bs-toggle="dropdown" aria-expanded="false">
                                <?php echo $buttonText; ?>
                            </button>

                            <ul class="dropdown-menu" aria-labelledby="dropdownSortingButton">
                                <li><a class="dropdown-item" href="?sort=latest">Latest Jobs</a></li>
                                <li><a class="dropdown-item" href="?sort=salary">Highest Salary Jobs</a></li>
                            </ul>
                        </div>

                    </div>

                    <?php
                    //MARK: main part
                    //moved the list part to the top to integrate the search
                    foreach ($list as $jobPost) {
                        $companyName = strtolower(str_replace(' ', '_', $jobPost['Company'])); // Replace spaces with underscores and convert to lowercase
                        $imagePath = 'images/logos/'; // Replace this with the actual path to your images
                        $imageSrc = $imagePath . $companyName . '.png';
                        if (!file_exists($imageSrc)) {
                            $imageSrc = $imagePath . 'generic.png';
                        }
                    ?>
                        <div class="col-lg-4 col-md-6 col-12">
                            <div class="job-thumb job-thumb-box">
                                <div class="job-image-box-wrap">
                                    <a href="job-details.php?id=<?php echo $jobPost['JobID']; ?>">
                                        <img src="images/jobs/it-professional-works-startup-project.jpg" class="job-image img-fluid" alt="">
                                    </a>

                                    <div class="job-image-box-wrap-info d-flex align-items-center">
                                        <p class="mb-0">
                                            <a href="job-listings.html" class="badge badge-level"><?php echo $jobPost['FieldName']; ?></a>
                                        </p>
                                        <p class="mb-0">
                                            <a href="job-listings.html" class="badge badge-level"><?php echo $jobPost['LevelName']; ?></a>
                                        </p>

                                        <p class="mb-0">
                                            <a href="job-listings.html" class="badge"><?php echo $jobPost['EmploymentTypeName']; ?></a>
                                        </p>
                                    </div>
                                </div>

                                <div class="job-body">
                                    <h4 class="job-title">
                                        <a href="job-details.php?id=<?php echo $jobPost['JobID']; ?>" class="job-title-link"><?php echo $jobPost['Title']; ?></a>
                                    </h4>

                                    <div class="d-flex align-items-center">
                                        <div class="job-image-wrap d-flex align-items-center bg-white shadow-lg mt-2 mb-4">
                                            <img src="<?php echo $imageSrc; ?>" class="job-image me-3 img-fluid" alt="">

                                            <p class="mb-0"><?php echo $jobPost['Company']; ?></p>
                                        </div>

                                        <a href="#" class="bi-bookmark ms-auto me-2">
                                        </a>

                                        <a href="#" class="bi-heart">
                                        </a>
                                    </div>

                                    <div class="d-flex align-items-center">
                                        <p class="job-location">
                                            <i class="custom-icon bi-geo-alt me-1"></i>
                                            <?php echo $jobPost['Location']; ?>
                                        </p>

                                        <p class="job-date">
                                            <i class="custom-icon bi-clock me-1"></i>
                                            <?php echo $jobPost['PostingDate']; ?>
                                        </p>
                                    </div>

                                    <div class="d-flex align-items-center border-top pt-3">
                                        <p class="job-price mb-0">
                                            <i class="custom-icon bi-cash me-1"></i>
                                            <?php echo $jobPost['Salary']; ?> TND
                                        </p>

                                        <a href="job-details.php?id=<?php echo $jobPost['JobID']; ?>" class="custom-btn btn ms-auto">Apply now</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php
                    }
                    ?>

                </div>
            </div>
        </section>


        <section class="cta-section">
            <div class="section-overlay"></div>

            <div class="container">
                <div class="row">

                    <div class="col-lg-6 col-10">
                        <h2 class="text-white mb-2">Over 10k opening jobs</h2>

                        <p class="text-white">Gotto Job is a free HTML CSS template for job hunting related websites. This layout is based on the famous Bootstrap 5 CSS framework. Thank you for visiting Tooplate website.</p>
                    </div>

                    <div class="col-lg-4 col-12 ms-auto">
                        <div class="custom-border-btn-wrap d-flex align-items-center mt-lg-4 mt-2">
                            <a href="#" class="custom-btn custom-border-btn btn me-4">Create an account</a>

                            <a href="#" class="custom-link">Post a job</a>
                        </div>
                    </div>

                </div>
            </div>
        </section>
    </main>

    <footer class="site-footer">
        <div class="container">
            <div class="row">

                <div class="col-lg-4 col-md-6 col-12 mb-3">
                    <div class="d-flex align-items-center mb-4">
                        <img src="images/logo.png" class="img-fluid logo-image">

                        <div class="d-flex flex-column">
                            <a class="logo-text">5ademni</a>
                            <small class="logo-slogan">Online Job Portal</small>
                        </div>
                    </div>

                    <p class="mb-2">
                        <i class="custom-icon bi-globe me-1"></i>

                        <a href="#" class="site-footer-link">
                            www.jobbportal.com
                        </a>
                    </p>

                    <p class="mb-2">
                        <i class="custom-icon bi-telephone me-1"></i>

                        <a href="tel: 305-240-9671" class="site-footer-link">
                            305-240-9671
                        </a>
                    </p>

                    <p>
                        <i class="custom-icon bi-envelope me-1"></i>

                        <a href="mailto:info@yourgmail.com" class="site-footer-link">
                            info@jobportal.co
                        </a>
                    </p>

                </div>

                <div class="col-lg-2 col-md-3 col-6 ms-lg-auto">
                    <h6 class="site-footer-title">Company</h6>

                    <ul class="footer-menu">
                        <li class="footer-menu-item"><a href="#" class="footer-menu-link">About</a></li>

                        <li class="footer-menu-item"><a href="#" class="footer-menu-link">Blog</a></li>

                        <li class="footer-menu-item"><a href="#" class="footer-menu-link">Jobs</a></li>

                        <li class="footer-menu-item"><a href="#" class="footer-menu-link">Contact</a></li>
                    </ul>
                </div>

                <div class="col-lg-2 col-md-3 col-6">
                    <h6 class="site-footer-title">Resources</h6>

                    <ul class="footer-menu">
                        <li class="footer-menu-item"><a href="#" class="footer-menu-link">Guide</a></li>

                        <li class="footer-menu-item"><a href="#" class="footer-menu-link">How it works</a></li>

                        <li class="footer-menu-item"><a href="#" class="footer-menu-link">Salary Tool</a></li>
                    </ul>
                </div>

                <div class="col-lg-4 col-md-8 col-12 mt-3 mt-lg-0">
                    <h6 class="site-footer-title">Newsletter</h6>

                    <form class="custom-form newsletter-form" action="#" method="post" role="form">
                        <h6 class="site-footer-title">Get notified jobs news</h6>

                        <div class="input-group">
                            <span class="input-group-text" id="basic-addon1"><i class="bi-person"></i></span>

                            <input type="text" name="newsletter-name" id="newsletter-name" class="form-control" placeholder="yourname@gmail.com">

                            <button type="submit" class="form-control">
                                <i class="bi-send"></i>
                            </button>
                        </div>
                    </form>
                </div>

            </div>
        </div>

        <div class="site-footer-bottom">
            <div class="container">
                <div class="row">

                    <div class="col-lg-4 col-12 d-flex align-items-center">
                        <p class="copyright-text">Copyright © 5ademni 2048</p>

                        <ul class="footer-menu d-flex">
                            <li class="footer-menu-item"><a href="#" class="footer-menu-link">Privacy Policy</a></li>

                            <li class="footer-menu-item"><a href="#" class="footer-menu-link">Terms</a></li>
                        </ul>
                    </div>

                    <div class="col-lg-5 col-12 mt-2 mt-lg-0">
                        <ul class="social-icon">
                            <li class="social-icon-item">
                                <a href="#" class="social-icon-link bi-twitter"></a>
                            </li>

                            <li class="social-icon-item">
                                <a href="#" class="social-icon-link bi-facebook"></a>
                            </li>

                            <li class="social-icon-item">
                                <a href="#" class="social-icon-link bi-linkedin"></a>
                            </li>

                            <li class="social-icon-item">
                                <a href="#" class="social-icon-link bi-instagram"></a>
                            </li>

                            <li class="social-icon-item">
                                <a href="#" class="social-icon-link bi-youtube"></a>
                            </li>
                        </ul>
                    </div>
                    <!--
                    <div class="col-lg-3 col-12 mt-2 d-flex align-items-center mt-lg-0">
                        <p>Design: <a class="sponsored-link" rel="sponsored" href="https://www.tooplate.com" target="_blank">Tooplate</a></p>
                    </div>
                    -->
                    <a class="back-top-icon bi-arrow-up smoothscroll d-flex justify-content-center align-items-center" href="#top"></a>

                </div>
            </div>
        </div>
    </footer>

    <!-- JAVASCRIPT FILES -->
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <script src="js/counter.js"></script>
    <script src="js/custom.js"></script>
    <script src="js/input_control.js"></script>

</body>

</html>