<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Students View</title>
</head>
<body>
    <h1>Manage Students</h1>

    <form id="studentForm">
        <input type="hidden" id="studentId" name="studentId">
        <div>
            <label for="firstname">First Name:</label>
            <input type="text" id="firstname" name="firstname" placeholder="Enter the firstname" required>
        </div>
        <div>
            <label for="middlename">Middle Name:</label>
            <input type="text" id="middlename" name="middlename" placeholder="Enter the middlename" required>
        </div>
        <div>
            <label for="lastname">Last Name:</label>
            <input type="text" id="lastname" name="lastname" placeholder="Enter the lastname" required>
        </div>
        <div>
            <label for="age">Age:</label>
            <input type="number" id="age" name="age" placeholder="Enter the age" required>
        </div>
        <button type="submit">Save Student</button>
    </form>
    <h2>Students</h2>
    <ul id="studentList"></ul>

    <script>
        document.addEventListener('DOMContentLoaded', async function() {
            await fetchStudents();

            document.getElementById('studentForm').addEventListener('submit', async function(event) {
                event.preventDefault();

                let studentId = document.getElementById('studentId').value;
                let formData = {
                    firstname: document.getElementById('firstname').value,
                    middlename: document.getElementById('middlename').value,
                    lastname: document.getElementById('lastname').value,
                    age: document.getElementById('age').value
                };

                if (studentId) {
                    await updateStudent(studentId, formData);
                } else {
                    await addStudent(formData);
                }

                document.getElementById('studentForm').reset();
                document.getElementById('studentId').value = '';

                await fetchStudents();
            });
        });

        async function fetchStudents() {
            let response = await fetch('http://localhost:8000/api/students');
            let result = await response.json();
            let students = result.data;
            let studentList = document.getElementById('studentList');
            studentList.innerHTML = '';

            if (Array.isArray(students)) {
                students.forEach(student => {
                    let li = document.createElement('li');
                    li.textContent = `${student.firstname} ${student.middlename} ${student.lastname} (Age: ${student.age})`;

                    let editButton = document.createElement('button');
                    editButton.textContent = 'Edit';
                    editButton.onClick = () => loadStudent(student);
                    li.appendChild(editButton);

                    let deleteButton = document.createElement('button');
                    deleteButton.textContent = 'Delete';
                    deleteButton.onClick = async () => {
                        await deleteStudent(student.id);
                        await fetchStudents();
                    };
                    li.appendChild(deleteButton);

                    studentList.appendChild(li);
                });
            } else {
                console.error('Expected an array but got:', students);
            }
        }

        function loadStudent(student) {
            document.getElementById('studentId').value = student.id;
            document.getElementById('firstname').value = student.firstname;
            document.getElementById('middlename').value = student.middlename;
            document.getElementById('lastname').value = student.lastname;
            document.getElementById('age').value = student.age;
        }

        async function addStudent(formData) {
            await fetch('http://localhost:8000/api/students', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(formData)
            });
        }
        
        async function updateStudent(id, formData) {
            await fetch(`http://localhost:8000/api/students/${id}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(formData)
            });
        }

        async function deleteStudent(id) {
            await fetch(`http://localhost:8000/api/students/${id}`, {
                method: 'DELETE'
            })
        }
    </script>
</body>
</html>