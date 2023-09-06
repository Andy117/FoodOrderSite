<?php
    include('partials/menu.php');
?>
    <main>
        <div class="main-content">
            <div class="wrapper">
                <h1><strong>PANEL DE CONTROL</strong></h1><br><br>
                <?php 
                if(isset($_SESSION['login']))
                {
                    echo $_SESSION['login'];
                    unset($_SESSION['login']);
                }
            
                ?> <br><br>
                <div class="col-4 text-center">
                    <h1>5</h1>
                    <br>
                    Categorias
                </div>
                <div class="col-4 text-center">
                    <h1>5</h1>
                    <br>
                    Categorias
                </div>
                <div class="col-4 text-center">
                    <h1>5</h1>
                    <br>
                    Categorias
                </div>
                <div class="col-4 text-center">
                    <h1>5</h1>
                    <br>
                    Categorias
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </main>
    <?php
    include('partials/footer.php');
?>