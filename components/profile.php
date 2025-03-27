<div class="user-profile shadow " style="height: 100dvh;">
    <i onclick="info()" class="fa-solid fa-arrow-left fa-xl"
        style="color: #ffffff; position:absolute; left:-20px; margin:10px auto;"></i>

    <div class="banner ">
        <img src="banner2.jpg" class="banner-img" alt="profile">

    </div>
    <div class="details">
        <img src="new.png" id='avatar' class="avatar" alt="profile">
        <span id='username' class="font username" id="username"><?= $chat->getSenderUsername($_GET['id']);?> </span>
        <!-- <button class="save"></button> -->

        <!-- <input type="text" class="edit font username" value="Username"> -->
        <div class="line"></div>
        <div class="description font info">Joined
            <?php echo (new DateTime($user->getJoinDate()))->format('d.m.Y');       ?></div>
        <div class="description font bio">
            <?= $user->getUserBio($_GET['id']);?>
        </div>

    </div>
    <!-- <h3 class="ustawienia font ">Settings</h3> -->
    <div class="settings ">
        <e class="font">Settings</e>
        <div class="setting shadow" onclick="editUsername()">
            <i class="set-icon fa-solid fa-user fa-xl"></i>
            <div class="title font">Nicki</div>
        </div>
        <div class="setting shadow theme" onclick='themes();'>
            <i class="set-icon fa-solid fa-palette fa-xl"></i>
            <div class="title font">Motywy</div>
        </div>

        <div class="settings">
            <form action="" id="addTheme" enctype="multipart/form-data"></form>
            <label for="file" class="setting shadow theme file" style="display: none;">
                <i class="set-icon fa-solid fa-palette fa-xl"></i>
                <input type="file" name="file" id="file" class="inputfile" style="display: none;" />
                <div class="title font">Dodaj swój motyw</div>

            </label>


            <input type="text" class="input themeName" name='name' placeholder="nazwa motywu">
            <span class="font">wychodzące wiadomosci</span>
            <input id="color2" class='input' name="outcoming" value='#d0d012' />
            <span class="font">przychodzące wiadomości</span>
            <input id="color" class='input' name="incoming" value='#276cb8' />
            <button class="save" onclick="addTheme()">Zapisz</button>
            </form>
        </div>

        <span class="font themeName"></span>
        <form method="POST" id="theme">
            <!-- <input type="text" class="themeId" name="id" type="hidden" value="1">   -->
            <input id='hiddenTheme' type="hidden" name="theme" value="1">
            <button type="submit" class="saveTheme button">Zapisz</button>
        </form>

    </div>

</div>

<script>
$('#color').spectrum({
    type: "component",
    showPalette: false
});
$('#color2').spectrum({
    type: "component",
    showPalette: false
});
</script>
<script>
const color1 = document.getElementById('color');
const color2 = document.getElementById('color2');
color1.onchange = (e) => {

    document.documentElement.style.setProperty('--incoming', e.target.value)
    // document.querySelectorAll('.incoming').style.background = e.target.value;

}
color2.onchange = (e) => {
    document.documentElement.style.setProperty('--outcoming', e.target.value)
    document.documentElement.style.setProperty('--inputs', e.target.value)
}

function addTheme() {
    const name = document.querySelector('.themeName').value;
    const incoming = document.querySelector('#color').value;
    const outcoming = document.querySelector('#color2').value;
    let form = document.getElementById("addTheme");
    let formData = new FormData(form);
    formData.append('file', document.getElementById('file').files[0]);
    formData.append('themeName', name);
    formData.append('incoming', incoming);
    formData.append('outcoming', outcoming);
    console.log(formData)
    quickXHR("xhr/add_theme.php", "POST", formData, "Pomyślnie dodano motyw")

}
</script>