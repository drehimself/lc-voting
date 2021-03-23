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
                <li class="list-group-item">6) <a href="https://jsonplaceholder.typicode.com/">API</a> use this api to fetch data and display on page only fetch posts with related comments</li>
            </ul>
        </div>
    </main>
</div>
</x-guest-layout>