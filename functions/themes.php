<script>
function useTheme(background) {
    let body = document.querySelector('body');
    document.body.style.background = `url('themes/${background}') no-repeat center center / cover`;
    // document.documentElement.style.setProperty('--background', `url(./themes/${background})`);
}

function themes() {
    let currentTheme = 0;
    let themes = [];
    let submit = document.querySelector('.saveTheme');
    let themeInput = document.getElementById('hiddenTheme');
    let form = document.getElementById('theme');
    let themeName = [];
    let themeLabel = document.querySelector('.themeName');
    <?php 
            $themes = $chat->getAllThemes();
            foreach ($themes as $theme): ?>
    themes.push("<?php echo $theme['background']; ?>");
    themeName.push("<?php echo $theme['name']; ?>");
    <?php endforeach; ?>


    let changeTheme = document.querySelector('.theme');

    changeTheme.onclick = () => {
        submit.style.display = 'block';
        submit.onclick = () => {
            // additional functionality here (if needed)
        };
        themeLabel.innerHTML = themeName[currentTheme];
        useTheme(themes[currentTheme]);
        themeInput.value = currentTheme + 1;
        currentTheme++;
        if (currentTheme >= themes.length) {
            currentTheme = 0;
        }




        form.onsubmit = (e) => {
            e.preventDefault();
            console.log(new FormData(form));
            quickXHR("xhr/set_theme.php", "POST", new FormData(form), "Successfully added theme");
        };
    };
}

function addTheme() {
    quickXHR("xhr/add_theme.php", "POST", document.getElementById("addTheme"), "Succesfully added theme");
}
</script>