<div class="sidebar">
    <div class="logo_content">
        <div class="logo">
            <img src="../assets/athena.svg" class="logo">
        </div>
        <a href="#"><i class='bx bx-menu' id="btn"></i></a>
    </div>
    <ul class="nav_list">
        <li>
            <a href="../Painel/">
                <i class='bx bx-grid-alt'></i>
                <span class="links_name">Dashboard</span>
            </a>
            <span class="tooltip">Dashboard</span>

        </li>
        <li>
            <a href="../Livros/index.php">
                <i class='bx bxs-book-alt'></i>
                <span class="links_name">Livros</span>
            </a>
            <span class="tooltip">Livros</span>

        </li>

        <li>
            <a href="../Emprestimos/index.php">
                <i class='bx bxs-bookmarks'></i>
                <span class="links_name">Empréstimos</span>
            </a>
            <span class="tooltip">Empréstimos</span>

        </li>

        <li>
            <a href="../Utilizadores/index.php">
                <i class='bx bxs-book-reader'></i>
                <span class="links_name">Leitores</span>
            </a>
            <span class="tooltip">Leitores</span>

        </li>
    </ul>

    <input type="checkbox" class="checkbox" id="checkbox">
    <label for="checkbox" class="label">
        <i class='bx bxs-moon'></i>
        <i class='bx bxs-sun'></i>
        <div class="ball"></div>
    </label>

    <div class="profile_content">
        <div class="profile">
            <div class="profile_details">
                <!-- <img src="profile.jpg" alt="Foto de perfil do usuário"> -->
                <div class="name_job">
                    <div class="name"><?php echo $_SESSION["nome"] ?></div>
                    <div class="job">Bem Vindo!</div>
                </div>
            </div>
            <a href="../logout.php" style="color: inherit">
                <i class='bx bx-log-out' id="log_out"></i>
            </a>
        </div>
    </div>
</div>

<script>
    let btn = document.querySelector("#btn");
    let sidebar = document.querySelector(".sidebar");
    let toggle = window.localStorage.getItem("toggle");
    let theme = window.localStorage.getItem("theme");
    const checkbox = document.getElementById('checkbox');
    sidebar.classList.toggle(toggle);


    btn.onclick = function() {
        if (toggle != "active") {
            toggle = "active";
            window.localStorage.setItem("toggle", "active");
        } else {
            window.localStorage.setItem("toggle", "hidden");
        }
        sidebar.classList.toggle(toggle);
    }

    checkbox.addEventListener('change', () => {

        // Trocar o tema do site
        if (theme != "dark") {
            theme = "dark";
            window.localStorage.setItem("theme", "dark");
        } else {
            window.localStorage.setItem("theme", "");
        }
        setDarkTheme(theme);


    })

    function setDarkTheme(_theme) {
        if (theme == "") {
            return;
        } else {
            let emp = document.querySelectorAll('body, .emprestimos_header, .botao_tabela, #tabela_emprestimos th, #tabela_emprestimos td, #tabela_emprestimos, .conteudo1 .subConteudo1, .subConteudo2, .subConteudo3, .conteudo1, .conteudo2, .conteudo3, .lateral, .principal, .alerta_emprestimo');
            for (var i = 0; i < emp.length; i++) {
                emp[i].classList.toggle(_theme);
            }
        }
    }
    document.addEventListener('DOMContentLoaded', (event) => {
        if (window.localStorage.getItem("theme") == "dark") {
            checkbox.checked = true;
        }
        setDarkTheme("dark");
    })
</script>