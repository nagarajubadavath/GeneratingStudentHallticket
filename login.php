<?php
if($_SERVER["REQUEST_METHOD"]=="POST")
{
    $Email = $_POST['email'];
    $Password = $_POST['pwd'];

    // Database connection
    $conn=new mysqli('localhost:3306', 'raju', 'Nagaraju1136@', 'Hallticket');
    if($conn->connect_error){
        die('Connection Failed:'.$conn->connect_error);
    }

    // Prepared statement to fetch user details
    $stmt = $conn->prepare("SELECT * FROM registration WHERE email = ?");
    $stmt->bind_param("s",$Email);
    $stmt->execute();
    $stmt_result = $stmt->get_result();

    if ($stmt_result->num_rows>0){
        $data = $stmt_result->fetch_assoc();
        if ($data['password'] === $Password) {
            // Fetch branch from registration data
            $branch = $data['branch'];

            // Fetching subjects data for the given branch
            $stmt_subjects = $conn->prepare("SELECT * FROM subjects WHERE branch = ?");
            $stmt_subjects->bind_param("s", $branch);
            $stmt_subjects->execute();
            $subjects_result = $stmt_subjects->get_result();

            if ($subjects_result->num_rows > 0) {
                $subjects_data = $subjects_result->fetch_assoc();
                // Display hall ticket
                ?>
                <!DOCTYPE html>
                <html lang="en">
                <head>
                    <meta charset="UTF-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <title>Hall Ticket</title>
                    <style>
                          body {
                        display: flex;
                        flex-direction: column;
                        align-items: center;
                        justify-content: center;
                        height: 100vh;
                        margin: 0;
                        background-color: #f0f0f0; /* Example background color */
                        }
                    
                    h1 {
                        margin: 0; /* Reset default margin */
                    }
                    table{
                        border-collapse:collapse;
                        width:100;
                        table-layout:500px;
                        border:2px solid black;
                    }
                    td{
                        padding:20px;
                    }
                    .sign{
                        text-align:center;
                    }
                    .print{
                        padding:10px;
                        margin-top:10px;
                    }
                    </style>
                    <body>
                            <h1>Hallticket</h1>
                            <table border=1>
                                <tr>
                                    <td>Name:</td>
                                    <td colspan="3"><?php echo htmlspecialchars($data['Name']); ?></td>
                                    <td rowspan="3"><img src="<?php echo htmlspecialchars($data['photo']); ?>"</td>
                                </tr>
                                <tr>
                                    <td>ID:</td>
                                    <td colspan="3"><?php echo htmlspecialchars($data['id']); ?></td>
                                </tr>
                                <tr>
                                    <td>Branch:</td>
                                    <td colspan="3"><?php echo htmlspecialchars($data['branch']); ?></td>
                                    
                                </tr>
                                <tr>
                                    <td>Subject:</td>
                                    <td><?php echo htmlspecialchars($subjects_data['subject1']); ?></td>
                                    <td><?php echo htmlspecialchars($subjects_data['subject2']); ?></td>
                                    <td><?php echo htmlspecialchars($subjects_data['subject3']); ?></td>
                                    <td rowspan="3" class="sign"><?php echo htmlspecialchars($data['Name']); ?></td>
                                </tr>
                                <tr>
                                    <td>Date:</td>
                                    <td><?php echo htmlspecialchars($subjects_data['exam_date']); ?></td>
                                    <td><?php echo htmlspecialchars($subjects_data['exam_date']); ?></td>
                                    <td><?php echo htmlspecialchars($subjects_data['exam_date']); ?></td>
                                </tr>
                                <tr>
                                    <td>Time:</td>
                                    <td><?php echo htmlspecialchars($subjects_data['exam_time']); ?></td>
                                    <td><?php echo htmlspecialchars($subjects_data['exam_time']); ?></td>
                                    <td><?php echo htmlspecialchars($subjects_data['exam_time']); ?></td>
                                </tr>
                </table>
                        <button onclick="window.print()">print</button>
                    </body>
                </html>
                <?php
            }else{
                echo "<p>No subjects found for your branch.</p>";
            }
        } else {
            echo "<h2>Invalid Email or Password</h2>";
        }
    } else {
        echo "<h2>Invalid Email or Password</h2>";
    }

    // Close prepared statements and database connection
    $stmt->close();
    $stmt_subjects->close();
    $conn->close();
}
?>
