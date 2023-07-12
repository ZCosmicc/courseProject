<?php
require('koneksi.php');

//Get all data
function getData($table)
{
    global $koneksi;
    $result = mysqli_query($koneksi, "SELECT * FROM $table");
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}

// Add new course to the database
function addCourse($courselist) {
    global $koneksi;
    
    // Escape the values to prevent SQL injection
    $courseName = mysqli_real_escape_string($koneksi, $courselist['course_name']);
    $description = mysqli_real_escape_string($koneksi, $courselist['course_description']);
    $deadlineDate = mysqli_real_escape_string($koneksi, $courselist['deadline_date']);
    
    // Prepare the SQL query
    $sql = "INSERT INTO courses (course_name, course_description, deadline_date) 
            VALUES ('$courseName', '$description', '$deadlineDate')";
    
    // Execute the query
    if (mysqli_query($koneksi, $sql)) {
      // Course added successfully
      return mysqli_insert_id($koneksi); // Return the ID of the newly inserted project
    } else {
      // Failed to add course
      echo "Error: " . $sql . "<br>" . mysqli_error($koneksi);
      return 0; // Return 0 to indicate failure
    }
    
    // Close the database connection
    mysqli_close($koneksi);
}

// Update the course in the database based on the submitted data
function updateCourse($courseData) {
    global $koneksi;

    $courseID = mysqli_real_escape_string($koneksi, $courseData['course_id']);
    $courseName = mysqli_real_escape_string($koneksi, $courseData['course_name']);
    $description = mysqli_real_escape_string($koneksi, $courseData['course_description']);
    $deadlineDate = mysqli_real_escape_string($koneksi, $courseData['deadline_date']);

    $query = "UPDATE courses SET 
                course_name = '$courseName',
                course_description = '$description',
                deadline_date = '$deadlineDate'
                WHERE course_id = $courseID";
    mysqli_query($koneksi, $query);
    return mysqli_affected_rows($koneksi);
}

// Search for courses in the database based on the search query
function searchCourse($searchQuery) {
    global $koneksi;

    $query = "SELECT * FROM courses WHERE course_name LIKE '%$searchQuery%' OR course_description LIKE '%$searchQuery%'";
    $result = mysqli_query($koneksi, $query);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}

// Delete the course in the database
function deleteCourse($courseID) {
    global $koneksi;

    $query = "DELETE FROM courses WHERE course_id = $courseID";
    mysqli_query($koneksi, $query);
    return mysqli_affected_rows($koneksi);
}

// Add new learning material to the database
function addMaterial($materialData) {
    global $koneksi;
    
    // Escape the values to prevent SQL injection
    $materialName = mysqli_real_escape_string($koneksi, $materialData['material_name']);
    $materialDescription = mysqli_real_escape_string($koneksi, $materialData['material_description']);
    $materialLink = mysqli_real_escape_string($koneksi, $materialData['material_link']);
    $courseID = mysqli_real_escape_string($koneksi, $materialData['course_id']);
    
    // Prepare the SQL query
    $sql = "INSERT INTO materials (material_name, material_description, material_link, course_id) 
            VALUES ('$materialName', '$materialDescription', '$materialLink', '$courseID')";
    
    // Execute the query
    if (mysqli_query($koneksi, $sql)) {
      // Material added successfully
      return mysqli_insert_id($koneksi); // Return the ID of the newly inserted learning material
    } else {
      // Failed to add task
      echo "Error: " . $sql . "<br>" . mysqli_error($koneksi);
      return 0; // Return 0 to indicate failure
    }
    
    // Close the database connection
    mysqli_close($koneksi);
}

// Update the learning material in the database based on the submitted data
function updateMaterial($materialData) {
    global $koneksi;

    $materialID = mysqli_real_escape_string($koneksi, $materialData['material_id']);
    $materialName = mysqli_real_escape_string($koneksi, $materialData['material_name']);
    $materialDescription = mysqli_real_escape_string($koneksi, $materialData['material_description']);
    $materialLink = mysqli_real_escape_string($koneksi, $materialData['material_link']);

    $query = "UPDATE materials SET 
                material_name = '$materialName',
                material_description = '$materialDescription',
                material_link = '$materialLink'
                WHERE material_id = $materialID";
    mysqli_query($koneksi, $query);
    return mysqli_affected_rows($koneksi);
}

// Delete the learning material in the database
function deleteMaterial($materialID) {
    global $koneksi;

    $query = "DELETE FROM materials WHERE material_id = $materialID";
    mysqli_query($koneksi, $query);
    return mysqli_affected_rows($koneksi);
}

?>