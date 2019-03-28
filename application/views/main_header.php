<nav id="main_header" class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
    <!--    <a class="navbar-brand" href="#">Navbar</a>-->
    <?php echo anchor("home/index", image('agriconLogo.png', 'class="agricon-agriconlogo"')); ?>
    <!--    <a class="navbar-brand" href="#">Navbar</a>-->
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault"
            aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarsExampleDefault">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link" href="<?php echo site_url('home/producten'); ?>">Producten</a>
            </li>
            <?php
            // wanneer user is ingelogd is -> navigatie tonen
            if (isset($user)) {
            ?>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="http://example.com" id="navbarDropdownMenuLink"
                   data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Beheren
                </a>
                <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                    <!--submenu1-->
                    <li>
                    <li><a class="dropdown-item" href="<?php echo site_url('product/beheren'); ?>">Producten</a></li>
                    <!--submenu2-->
                    <li class="dropdown-submenu"><a class="dropdown-item dropdown-toggle" href="#">Grondstoffen</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="<?php echo site_url('grondstof_afgewerkt/beheren'); ?>">Grondstoffen</a>
                            </li>
                            <li><a class="dropdown-item" href="<?php echo site_url('grondstof_ruw/beheren'); ?>">Grondstoffen
                                    Ruw</a></li>
                            <li><a class="dropdown-item" href="<?php echo site_url('grondstof_categorie/beheren'); ?>">Grondstofcategorieën </a>
                            </li>
                        </ul>
                    </li>
                    <!--submenu3-->
                    <li class="dropdown-submenu"><a class="dropdown-item dropdown-toggle" href="#">Folies</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item"
                                   href="<?php echo site_url('folie_gesneden/beheren'); ?>">Folies</a></li>
                            <li><a class="dropdown-item" href="<?php echo site_url('folie_ruw/beheren'); ?>">Folies
                                    Ruw</a></li>
                        </ul>
                    </li>
                    <!--submenu4-->
                    <li class="dropdown-submenu"><a class="dropdown-item dropdown-toggle" href="#">Leveranciers</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="<?php echo site_url('leverancier/beheren'); ?>">Leveranciers</a>
                            </li>
                            <li><a class="dropdown-item" href="<?php echo site_url('leverancier_soort/beheren'); ?>">Leverancier
                                    Soorten</a></li>
                            <li><a class="dropdown-item"
                                   href="<?php echo site_url('stadgemeente/beheren'); ?>">Steden</a></li>
                            <li><a class="dropdown-item" href="<?php echo site_url('land/beheren'); ?>">Landen</a></li>
                        </ul>
                    </li>
                    <!--submenu5-->
                    <li class="dropdown-submenu"><a class="dropdown-item dropdown-toggle" href="#">Kosten</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="<?php echo site_url('kost_elektriciteit/beheren'); ?>">Elektriciteit</a>
                            </li>
                            <li><a class="dropdown-item" href="<?php echo site_url('kost_gebouwen/beheren'); ?>">Gebouwen</a>
                            </li>
                            <li><a class="dropdown-item" href="<?php echo site_url('kost_personeel/beheren'); ?>">Personeel</a>
                            </li>
                            <li><a class="dropdown-item" href="<?php echo site_url('kost_machines/beheren'); ?>">Machines</a>
                            </li>
                            <li><a class="dropdown-item" href="<?php echo site_url('machine_soort/beheren'); ?>">Machinesoorten</a>
                            </li>
                        </ul>
                    </li>
                    <!--submenu6-->
                    <li class="dropdown-submenu"><a class="dropdown-item dropdown-toggle" href="#">Configuratie</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item"
                                   href="<?php echo site_url('configuratie/eenheden_beheren'); ?>">Eenheden</a></li>
                            <li><a class="dropdown-item"
                                   href="<?php echo site_url('configuratie/verpakkingskosten_beheren'); ?>">Verpakkingkosten</a>
                            </li>
                            <li><a class="dropdown-item" href="<?php echo site_url('configuratie/omzet_beheren'); ?>">Jaaromzet
                                    schattingen</a></li>
                        </ul>
                    </li>
                    <li>
                    <li><a class="dropdown-item" href="<?php echo site_url('database_backup/index'); ?>">Database
                            backups</a></li>
                    <?php
                    if ($user->level == 5) {
                        ?>
                        <li>
                        <li><a class="dropdown-item" href="<?php echo site_url('user/gebruikers_beheren'); ?>">Gebruikers</a>
                        </li>
                        <?php
                    }
                    ?>
                </ul>
            </li>
        </ul>

        <?php
        $dataOpen = array(
            'id' => 'form_logout',
            'name' => 'form_logout',
            'data-toggle' => 'validator',
            'role' => 'form',
            'class' => 'form-inline my-2 my-lg-0');

        $dataSubmit = array(
            'id' => 'submit_logout',
            'name' => 'submit_logout',
            'type' => 'submit',
            'value' => 'Logout',
            'class' => 'btn btn-outline-success my-2 my-sm-0');

        echo '<ul class="navbar-nav mr-auto"></ul>';
        echo form_open('user/logout', $dataOpen);
        echo form_submit($dataSubmit) . "\n";
        echo form_close();
        }
        // wanneer user niet ingelogd is -> inlog formulier tonen
        else {
            echo '</ul>';
            echo '<ul class="navbar-nav mr-auto"></ul>'; //nodig om de inline form rechts te laten floaten

            $dataOpen = array(
                'id' => 'form_login',
                'name' => 'form_login',
                'data-toggle' => 'validator',
                'role' => 'form',
                'class' => 'form-inline');

            $dataSubmit = array(
                'id' => 'submit_login',
                'name' => 'submit_login',
                'type' => 'submit',
                'value' => 'Login',
                'class' => 'btn btn-outline-success');

            echo '<ul class="navbar-nav mr-auto"></ul>';
            echo form_open('user/login', $dataOpen);
            echo form_input('user_naam', '', 'class="form-control mr-sm-2"
            required="required" placeholder="Naam" autofocus aria-label="user naam"');
            echo form_password('user_wachtwoord', '', 'class="form-control mr-sm-2"
            required="required" placeholder="Wachtwoord" aria-label="user wachtwoord"');
            echo form_submit($dataSubmit) . "\n";
            echo form_close();
            ?>
        <?php } ?>
        
    </div>
</nav>
<script>
    //    voorkom dat bij het klikken op de header in een dropdown-menu zorgt dat de dropdown menu sluit
    $(document).on('click', '.dropdown-header', function (e) {
        e.stopPropagation();
    });
</script>
