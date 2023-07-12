<?php
session_start();
require("model.php");

$courseID = !empty($_GET['course_id']) ? $_GET['course_id'] : '';
$materialID = !empty($_GET['material_id']) ? $_GET['material_id'] : '';
$courselists = getData("courses");
$materiallists = getData("materials");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (isset($_POST["submit"])) {
    $materialData = array(
      "material_id" => $_POST["material_id"],
      "material_name" => $_POST["material_name"],
      "material_description" => $_POST["material_description"],
      "material_link" => $_POST["material_link"],
      "course_id" => $_POST["course_id"]
    );

    if (addMaterial($materialData) > 0) {
      echo "
        <script>
          alert('Material successfully added!');
          window.location.href = 'materialPage.php?course_id=$courseID';
        </script>
      ";
    } else {
      echo "
        <script>
          alert('Material failed to add!');
          window.location.href = 'materialPage.php?course_id=$courseID';
        </script>
      ";
    }
  }

  if (isset($_POST["edit"])) {
    $materialData = array(
      "material_id" => $_POST["material_id"],
      "material_name" => $_POST["material_name"],
      "material_description" => $_POST["material_description"],
      "material_link" => $_POST["material_link"]
    );

    if (updateMaterial($materialData) > 0) {
      echo "
        <script>
          alert('Material successfully updated!');
          window.location.href = 'materialPage.php?course_id=$courseID';
        </script>
      ";
    } else {
      echo "
        <script>
          alert('Material failed to update!');
          window.location.href = 'materialPage.php?course_id=$courseID';
        </script>
      ";
    }
  }
}

if (isset($_GET["material_id"])) {
  $materialID = $_GET["material_id"];
  $courseID = !empty($_GET['course_id']) ? $_GET['course_id'] : '';
  if (deleteMaterial($materialID) > 0) {
    echo "
      <script>  
        alert('Material successfully deleted!');
        window.location.href = 'materialPage.php?course_id=$courseID';
      </script>";
  } else {
    echo "
      <script>  
        alert('Material failed to delete!');
        window.location.href = 'materialPage.php?course_id=$courseID';
      </script>";
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
  <title>SIMP - Learning Materials Page</title>

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
    <?php if (!empty($courseID)) : ?>
      <?php $course = getData("courses WHERE course_id = $courseID")[0]; ?>
      <div class="main-panel">
        <div class="panel-hedding">
          <div class="row mb-4">
            <div class="col-md-6">
              <h1><?php echo $course["course_name"]; ?></h1>
              <p>Selected Course</p>
            </div>
            <div class="col-md-6">
              <div class="add-new">
                <a class="btn btn-primary" data-toggle="modal" data-target="#exampleModal-03" fdprocessedid="lmb1tq"> <i class="feather icon-plus"></i> Add new</a>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-12">
            <div class="card">
              <div class="card-title">
                <div class="card-title-left">
                  <h4 class="card-title-text">Learning Materials</h4>
                </div>
              </div>
              <div class="card-body">
                <div class="todo-task">
                  <ul class="list-group">
                    <?php foreach ($materiallists as $materiallist) : ?>
                      <?php if ($materiallist["course_id"] == $courseID) : ?>
                        <li class="list-group-item">
                          <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="<?php echo $materiallist["material_id"]; ?>">
                            <label class="custom-control-label" for="<?php echo $materiallist["material_id"]; ?>"><?php echo $materiallist["material_name"]; ?></label>
                            <p class="task-status"><?php echo $materiallist["material_description"]; ?></p>
                          </div>
                          <div class="task-action">
                            <ul class="list-unstyled">
                              <a href="<?php echo $materiallist["material_link"]; ?>" class="task-status badge badge-overlay-primary">Click here to learn</a>
                              <li><a href="#editMaterialModal" data-toggle="modal" data-material-id="<?php echo $materiallist["material_id"]; ?>" class="edit-task-button"><i class="la la-edit"></i></a></li>
                              <li><a href="?material_id=<?php echo $materiallist["material_id"]; ?>&course_id=<?php echo $courseID; ?>"><i class="la la-trash-o"></i></a></li>
                            </ul>
                          </div>
                        </li>
                      <?php endif; ?>
                    <?php endforeach; ?>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    <?php endif; ?>
  </div>

  <div class="modal fade" id="exampleModal-03" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Add New Learning Material</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body p-5">
          <form method="post">
            <div class="form-group">
              <label for="course_id" hidden>Course ID</label>
              <input type="text" class="form-control" name="course_id" value="<?= $courseID ?>" hidden>
            </div>
            <div class="form-group">
              <label for="material_name">Material Title</label>
              <input type="text" class="form-control" name="material_name" placeholder="Enter Material Title" required>
            </div>
            <div class="form-group">
              <label for="material_description">Description</label>
              <textarea class="form-control" name="material_description" placeholder="Enter Short Description" required></textarea>
            </div>
            <div class="form-group">
              <label for="material_link">Material Link</label>
              <input type="text" class="form-control" name="material_link" required>
            </div>
            <button type="submit" name="submit" class="btn btn-primary">Add Material</button>
          </form>
        </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="editMaterialModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Update Learning Material</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body p-5">
        <form method="post">
        <div class="form-group">
          <label for="material_id" hidden>Material ID</label>
          <input type="text" class="form-control" name="material_id" id="editMaterialID" value="<?php echo $materiallist["material_id"];?>" hidden>
        </div>
          <div class="form-group">
            <label for="material_name">Material Title</label>
            <input type="text" class="form-control" name="material_name" placeholder="Enter Material Title" value="<?php echo $materiallist["material_name"];?>">
          </div>
          <div class="form-group">
            <label for="material_description">Description</label>
            <textarea class="form-control" name="material_description" placeholder="Enter Short Description" required><?php echo $materiallist["material_description"];?></textarea>
          </div>
          <div class="form-group">
            <label for="material_link">Material Link</label>
            <input type="text" class="form-control" name="material_link" value="<?php echo $materiallist["material_link"];?>" required>
          </div>
          <button type="submit" name="edit" class="btn btn-primary">Update Material</button>
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