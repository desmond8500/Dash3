<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="dash/theme/dash.css">
    <title>Dash3</title>
</head>
<body>
    <div class="dash_nav">
        <div class="dash_nav_logo">
            <img src="{{ asset('dash/theme/icon/cell.png') }}" height="40px" alt="">
        </div>
        <div class="dash_nav_menus">
                <div class="dash_nav_menu">Images</div>
                <div class="dash_nav_menu">Gifs</div>
                <div class="dash_nav_menu">Videos</div>
        </div>
        <div class="dash_nav_profile">
            <img src="{{ asset('dash/theme/icon/user.png') }}" height="40px" alt="">
            Profile
        </div>
    </div>

    <div class="dash_wrapper">
        <div class="dash_page_title row">
            <div class="title col-1">
                Tableau de bord
            </div>

            <dash class="dash_breadcrumbs col-5">
                Images
            </dash>
        </div>

        <div class="row">
            <div class="col-1">
                <div class="dash_card">
                    Hello
                </div>
            </div>
            <div class="col-1">
                <div class="dash_card">
                    Hello
                </div>

            </div>
        </div>


    </div>

</body>
</html>
