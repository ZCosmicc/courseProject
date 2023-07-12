<?php
session_start();
require ("model.php");

  $courselists = getData("courses");

  if (isset($_GET["search"])) {
    $searchResults = searchCourse($_GET["search"]);
  } else {
    $searchResults = $courselists;
  }

  
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Check if the form was submitted

  // Call the addCourse function
  if (isset($_POST["submit"])) {
    $courseData = array(
      "course_id" => $_POST["course_id"],
      "course_name" => $_POST["course_name"],
      "course_description" => $_POST["course_description"],
      "deadline_date" => $_POST["deadline_date"]
    );

    if(addCourse($courseData) > 0) {
      echo "
      <script>
        alert('Course successfully added!');
            window.location.href = 'index.php';
      </script>
      ";
    } else {
      echo "
      <script>
        alert('Course failed to added!');
            window.location.href = 'index.php';
      </script>
      ";
    }
  }

  // Call the updateCourse function
  if (isset($_POST["edit"])) {
    $courseData = array(
      "course_id" => $_POST["course_id"],
      "course_name" => $_POST["course_name"],
      "course_description" => $_POST["course_description"],
      "deadline_date" => $_POST["deadline_date"]
    );

    if(updateCourse($courseData) > 0) {
      echo "
      <script>
        alert('Course successfully updated!');
        window.location.href = 'index.php';
      </script>
      ";
    } else {
      echo "
      <script>
        alert('Course failed to updated!');
        window.location.href = 'index.php';
      </script>
      ";
    }
  }
}

// Call the deleteCourse function
if (isset($_GET["course_id"])) {
  $courseID = $_GET["course_id"];
  if (deleteCourse($courseID) > 0) {
    echo "
    <script>
      alert('Course successfully deleted!');
      window.location.href = 'index.php';
    </script>
    ";
  } else {
    echo "
    <script>
      alert('Course failed to delete!');
      window.location.href = 'index.php';
    </script>
    ";
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="author" content="Infinitysoftway" />
<meta name="description" content="statistic charts">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
 
<!-- TITLE -->
<title>SIMP - Courses</title>

<!-- FAVICON -->
<link rel="shortcut icon" href="src\assets\images\favicon.ico" />

<!-- STYLE -->
<link rel="stylesheet" type="text/css" href="src\style\global.css">

</head>

<body>

<!-- **********  HEADER  ********** -->

<header class="header header-fixed header-light">
    <div class="header-middle">                 
        <div class="logo-color logo-color-light">
            <div class="logo">
                <div class="logo-middle">            
                <a href="index.php"><img src="src\assets\images\logo.svg" alt="Logo"></a>
                </div>
            </div>
        </div>
        <div class="header-topbar">
            <div class="topbar-left">
                <a class="side-toggle" href="#!">
                <i class="la la-bars"></i>  
                </a>
                <form action="index.php" method="GET">
                <div class="search-box">
                <div class="search">
                    <input class="form-control border-0" type="text" name="search" placeholder="Search project..." aria-label="Search">
                    <a type="submit"><i class="la la-search"></i></a>
                </div>
                </div>
                </form>
            </div>
        </div>
    </div>
</header>

<!-- **********  HEADER  ********** -->


<!-- **********  WRAPPER  ********** -->

<div class="wrapper">
  <div class="sidebar-panel nicescrollbar sidebar-panel-light">
    <ul class="sidebar-menu">
      <li class="sidebar-header"> Navigation </li>
        <li>
          <a href="index.php">
            <i class="la la-book"></i> <span>Courses</span>
          </a>
        </li>
    </ul>
  </div>

  <!-- **********  main-panel  ********** -->
  <div class="main-panel">
    <div class="panel-hedding">
      <div class="row mb-4">
        <div class="col-md-6">
          <h1>Your Courses</h1>
          <p>Let's get to work</p>
        </div>
        <div class="col-md-6">
            <div class="add-new">
              <a class="btn btn-primary" data-toggle="modal" data-target="#exampleModal-03" fdprocessedid="lmb1tq"> <i class="feather icon-plus"></i> Add new</a>
            </div>
        </div>
      </div>
    </div>
    <div class="row">
      <?php foreach ($searchResults as $courselist) : ?>
          <div class="col-lg-4 col-sm-6">
              <div class="card">
                <a href="materialPage.php?course_id=<?php echo $courselist["course_id"]?>"><img class="card-img-top" src="src\assets\images\team\book.jpg" alt="Card image cap"></a>
                  <div class="card-body">
                      <div class="project-item">
                          <div class="project-title mb-3">
                              <div class="project-title-left">
                                  <h5><a href="materialPage.php?course_id=<?php echo $courselist["course_id"]?>"><?php echo $courselist["course_name"]; ?></a></h5>
                              </div>
                          </div>
                          <div class="project-comments mt-4">
                              <h6 class="mb-2">Description : </h6>
                              <p><?php echo $courselist["course_description"]; ?></p>
                          </div>
                          <div class="row mt-5">
                              <div class="col">
                                  <div class="project-deadline">
                                      <h6 class="mb-2">End date: </h6>
                                      <p><?php echo $courselist["deadline_date"]; ?></p>
                                  </div>
                              </div>
                          </div>
                          <div class="task-action">
                              <ul class="list-unstyled">
                              <li><a href="#editCourseModal" data-toggle="modal" data-course-id="<?php echo $courselist["course_id"]; ?>" class="edit-task-button"><i class="la la-edit"></i></a></li>
                                <li><a href="?course_id=<?php echo $courselist["course_id"];?>"><i class="la la-trash-o"></i></a></li>
                              </ul>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      <?php endforeach; ?>
    </div>

    <!-- Footer -->
    <footer class="footer pb-3">
        <div class="row text-center text-md-left">
          <div class="col-md-6">
            <p>Copyright © <script>document.write(new Date().getFullYear())</script> <strong><a target="_blank" href="https://www.zcostudio.tech/">SIMP | Fariz Fadillah</a></strong> All Rights Reserved</p>
          </div>
          <div class="col-md-6 text-md-right">
            <div class="footer-links">
              <ul class="list-unstyled list-inline mb-0">
            <li class="list-inline-item"><a class="text-dark" href="mailto:zencatzcosmic@gmail.com?subject=SIMP%20-%20ASK">Contact us</a></li>
              </ul>
            </div>
          </div>
        </div>
    </footer>
    <!-- Footer -->
  </div>
</div>


  <div class="modal fade" id="exampleModal-03" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Add New Course</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
      <div class="modal-body p-5">
        <form method="post">
        <div class="form-group">
          <label for="course_name">Course Name</label>
          <input type="text" class="form-control" name="course_name" placeholder="Enter Course Name" required>
        </div>
        <div class="form-group">
          <label for="description">Description</label>
          <textarea class="form-control" name="course_description" placeholder="Enter Course Description" required></textarea>
        </div>
        <div class="form-group">
          <label for="end_date">Deadline Date</label>
          <input type="date" class="form-control" name="deadline_date" required>
        </div>
          <button type="submit" name="submit" class="btn btn-primary">Add Course</button>
        </form>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="editCourseModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Edit Course</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
      <div class="modal-body p-5">
        <form method="post">
        <div class="form-group">
          <label for="course_name">Course Name</label>
          <input type="text" class="form-control" name="course_name" placeholder="Enter Course Name" value="<?php echo $courselist["course_name"]; ?>" required>
        </div>
        <div class="form-group">
          <label for="description">Description</label>
          <textarea class="form-control" name="course_description" placeholder="Enter Course Description" required><?php echo $courselist["course_description"]; ?></textarea>
        </div>
        <div class="form-group">
          <label for="end_date">Deadline Date</label>
          <input type="date" class="form-control" name="deadline_date" required>
        </div>
          <button type="submit" name="edit" class="btn btn-primary">Update Course</button>
        </form>
      </div>
    </div>
  </div>
</div>
 
<!-- **********  Wrapper  ********** -->


<!-- **********  Javascript  ********** -->

<!-- jquery -->
<script src="src\js\jquery-3.6.0.min.js"></script>

<!-- bootstrap -->
<script src="src\js\bootstrap\bootstrap.bundle.min.js"></script>

<!-- jquery-nicescroll -->
<script src="src\js\jquery-nicescroll\jquery.nicescroll.min.js"></script>

<!-- custom -->
<script src="src\js\custom.js"></script>
	
</body>

</html>