<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/tooltip/navbar.css">
</head>
<body>
    <div class="hero">
        <nav>
            <img src="/img/logo.jpg" class="logo">
            <ul>
                <li>
                    <a href="#">Home</a>
                    <a href="#">Lembur</a>
                    <a href="#">Persetujuan</a>
                    <a href="#">Pengaturan </a>
                </li>
            </ul>
            <img src="/img/user_image.png" class="user-pic" onclick="toggleMenu()">

            <div class="sub-menu-wrap" id="subMenu">
                <div class="sub-menu">
                    <div class="user-info">
                        <img src="/img/user_image.png">
                        <h2>Lattif Priatno</h2>
                    </div>
                    <hr>

                    <a href="#" class="sub-menu-link ">
                        <img src="/img/profile.png" >
                        <p>Edit Profile </p>
                        <span>></span>
                    </a>
                    <a href="#" class="sub-menu-link ">
                        <img src="/img/setting.png" >
                        <p>Pengaturan & Privasi</p>
                        <span>></span>
                    </a>
                    <a href="#" class="sub-menu-link ">
                        <img src="/img/help.png" >
                        <p>Help & Support</p>
                        <span>></span>
                    </a>
                    <a href="#" class="sub-menu-link ">
                        <img src="/img/logout.png" >
                        <p>Log Out</p>
                        <span>></span>
                    </a>

                </div>
            </div>

        </nav>
    </div>
    
    <script>
        let subMenu = document.getElementById("subMenu");

        function toggleMenu(){
            subMenu.classList.toggle("open-menu");
        }
    </script>

</body>
</html>