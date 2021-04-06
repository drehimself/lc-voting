<x-guest-layout>
<x-slot name="style">
    <style>
        ul > li {
            font-size:18px;
            padding:20px;
        }
    </style>
</x-slot>

<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid">
            <ul class="list-group list-group-flush" style="padding:20px;">
                <li class="list-group-item">1) Make user table with 3 types of users (user,admin,superadmin) <br>each type of user will have his separate dashboard mean a user cannot acces super admin,admin dashboard also admin cannot access user,super admin dashboard also add impersonate functionality for super admin to impersonate any user on site</li>
                <li class="list-group-item">2) Use Datatables.net library to show users data on superadmin dashboard – with our without server-side rendering....also make the editing and adding new record with ajax/jquery no page refresh</li>
                <li class="list-group-item">3) Use more front-end theme like AdminLTE/StartBootstrap admin theme</li>
                <li class="list-group-item">4) Email notification: send email whenever new user is entered/added/registered (only type user can register from register form admin can only be made by super admin) (use Mailgun or Mailtrap)</li>
                <li class="list-group-item">5) Make the project multi-language (using resources/lang folder)</li>
                <li class="list-group-item">6) <a href="https://jsonplaceholder.typicode.com/" style="color:red;font-weight:600">API</a> use this api to fetch data and display on page only fetch posts with related comments</li>
            </ul>
        </div>

        ssh-rsa AAAAB3NzaC1yc2EAAAADAQABAAACAQCjYgr4B2fgIJw3j98Vv+CiEY+hFVwOiOEEp1GZCfYmS/lko3bmllq3HdyzKGegkDv/1apABWcGQqjt1iu0g0J9WVcr6R7Qy9QTw5Obzwv8BzL65/pgI5GzvHfxChM2ye2vO6FoVdDfm0BkUGf3qE2tSMbAf263b8mlMUr44DgNUXbmcNa1MW2CwnJ7ahNz7efdVa4Jvf7SgqDrVlVlRpk4a7hXDoLMIX5XK3TdviwGPerr6sYVRqTyX2u9EK4vCk66kWr+Cc45udyRLuI10T6YN8c+w74W2VIzASiQMBnrYsh/+hTC+lHmchJafBqtXalRn2oF8QYMVMHeWrr2G/bZL1HZ9fB4VMnNwCkf6s7N3K6xM2EOXXxz+SGtkuFLi2n8ku0cHOO93fEriUsjM6ByxobZogA4HsY5ZCR158HGc6sa9dQVoTveZMndlIesEifQrFMfhNiApKSpxWoCeNwIcDug7mkbjwBucgRAn7dsmO3dEZG9duLx3I4lDZbXw+kjzAtLc4i3JpMKHgG1rdGc3/0Rs4Vb7d++NM4iBeJkRP56ngQT54Lz1NcyAAaqf7CFsVwZR6FVwt8JaQdE9xC6VtSVghatkAcRmTDdTfGmdz84JOgQPxYpjLDusc7JGaND6BxML0Irj394FPOTE6ZFnnDwATj0cAnRoscigX2JtQ== zainzulifqar21@gmail.com

    </main>
</div>
</x-guest-layout>