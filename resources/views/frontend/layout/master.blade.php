<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Office Software</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap');

        * {
            font-family: "Inter", sans-serif;
        }

        .dropdown-menus {
            position: absolute;
            top: 100%;
            margin: 0;
            padding: 0;
            right: 0;
            border: 1px solid #ddd;
            line-height: 1;
            border-radius: 5px;
            background: #335dff;
            display: none;
            transition: all .5s ease-in;
        }

        .dropdown-menus.show {
            display: block;
        }

        .dropdown-menus a {
            color: #fff;
        }

        #userDropdown {
            cursor: pointer;
        }

        ul {
            margin: 0;
            padding: 0;
            outline: none
        }

        li {
            list-style: none
        }

        a {
            text-decoration: none
        }

        header.header-area {
            position: relative;
            z-index: 99;
            background: #ffffff8a;
        }

        body {
            background-image: linear-gradient(to right top, #cbedee, #f3f2f3);
        }

        ul.dropdown-menu.show {
            padding: 0;
        }

        ul.dropdown-menu.show li {
            background: #277bbe;
            border-bottom: 1px solid #fff;
        }

        ul.dropdown-menu.show li a {
            color: #fff;
        }

        ul.dropdown-menu.show a {
            background: #277bbe;
            display: block;
            color: #fff;
            line-height: 1.5;
            border-radius: 0;
            text-align: left;
        }

        ul.dropdown-menu.show li a {
            padding: 0 !important;
        }

        .dropdown-item:hover {
            background: transparent;
        }
    </style>
</head>

<body>

    @include('frontend.layout.header')

    @yield('user_content')




    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
    <script>
        function updateTime() {
            const now = new Date();
            const options = {
                weekday: 'long',
                year: 'numeric',
                month: 'short',
                day: 'numeric',
                hour: 'numeric',
                minute: 'numeric',
                second: 'numeric',
                hour12: true
            };

            // Get formatted time and date
            const formattedTime = now.toLocaleString('en-US', options);

            // Format the output as "10 Nov 2024 (Sunday) | 2:55:52 PM"
            const formattedDate = formattedTime.replace(',', '').replace(' AM', 'AM').replace(' PM', 'PM');
            const finalOutput = formattedDate.replace(' ', ' | ');

            document.getElementById('current-time').innerText = finalOutput;
        }

        // Update the time every second
        setInterval(updateTime, 1000);
        updateTime(); // Initial call to set the time immediately
    </script>
    <script>
        // JavaScript to toggle dropdown visibility
        document.getElementById('userDropdown').addEventListener('click', function() {
            document.getElementById('dropdownMenu').classList.toggle('show');
        });

        // Close dropdown if clicked outside
        document.addEventListener('click', function(event) {
            var dropdown = document.getElementById('dropdownMenu');
            var toggle = document.getElementById('userDropdown');
            if (!toggle.contains(event.target) && !dropdown.contains(event.target)) {
                dropdown.classList.remove('show');
            }
        });
    </script>

</body>

</html>
