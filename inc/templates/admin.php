<div class="plugchat-admin-wrapper">

    <div class="plugchat-form">
        <?php settings_errors(); ?>
        <form method="post" action="options.php">
            <?php 
                settings_fields('plugchat-settings-group');
                do_settings_sections('alecadd_plugchat');
                submit_button()
            ?>
            
        </form>
    </div>
</div>


