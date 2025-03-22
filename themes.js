function useTheme(background){
    let body = document.querySelector('body');
    body.style.background = `url('themes/${background}') no-repeat center center / cover`;
}
function themes() {
    let currentTheme = 0;
    let themes = [];

    <?php 
        $themes = $chat->getAllThemes();
        foreach ($themes as $theme): ?>
            themes.push("<?php echo $theme['background']; ?>");
    <?php endforeach; ?>

    let changeTheme = document.querySelector('.setting:nth-child(2)');
    
    changeTheme.onclick = () => {
        currentTheme++;
        if (currentTheme >= themes.length) {
            currentTheme = 0;
        }
        useTheme(themes[currentTheme]);
    };

    useTheme(themes[currentTheme]);
}
