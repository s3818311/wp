/*---------------------------- browse.php ----------------------------*/
if (window.location.pathname.split('/')[2] == 'browse.php') {
    let selected_category = window.location.search.substr(1).split('=')[1] ? window.location.search.substr(1).split('=')[1] : 'all'

    let filterDivs = document.getElementById('filter-div-container').children

    const filter = (btnId) => {
        for (const div of filterDivs)
            if (div.classList.contains(btnId) || btnId == 'all')
                div.style.display = 'flex'
            else
                div.style.display = 'none'
    }
    filter(selected_category)


    let filterBtns = document.getElementById('filter-btn-container').children
    for (const btn of filterBtns) {
        if (btn.id == selected_category) btn.classList.add('active')

        btn.addEventListener('click', () => {
            filter(btn.id)
            for (const btn of filterBtns) btn.classList.remove('active')
            btn.classList.add('active')
        })
    }
}

/*---------------------------- admin.php -----------------------------*/
if (window.location.pathname.split('/')[2] == 'admin.php') {
    let tabcontent = document.getElementsByClassName("tabcontent")
    tabcontent[0].style.display = "block";
    for (let i = 1; i < tabcontent.length; i++)
        tabcontent[i].style.display = "none"

    let tablinks = document.getElementsByClassName("tablinks")
    for (const tablink of tablinks) {
        tablink.addEventListener('click', () => {
            for (let i = 0; i < tabcontent.length; i++)
                tabcontent[i].style.display = "none"
            for (let i = 0; i < tablinks.length; i++)
                tablinks[i].classList.remove("active")
            document.getElementById(tablink.innerHTML).style.display = 'block'
            tablink.classList.add("active")
        })
    }

    let tableRow = document.getElementsByClassName("adminTableRow")[7]
    let itemInpRow = document.getElementById('item-inp-row')
    for (let i = 0; i < itemInpRow.childElementCount; i++)
        itemInpRow.children[i].offsetWidth = tableRow.children[i].offsetWidth;
}
