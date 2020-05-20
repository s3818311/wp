let checkOutBtn = document.querySelector("#checkOutBtn")

let tabcontent = document.querySelectorAll(".tabcontent")
tabcontent[0].style.display = "block";
for (let i = 1; i < tabcontent.length; i++)
    tabcontent[i].style.display = "none"

let tablinks = document.querySelectorAll(".tablinks")
tablinks.forEach(tablink => {
    tablink.addEventListener('click', () => {
        for (let i = 0; i < tabcontent.length; i++)
            tabcontent[i].style.display = "none"
        for (let i = 0; i < tablinks.length; i++)
            tablinks[i].classList.remove("active")
        document.getElementById(tablink.innerHTML).style.display = 'block'
        tablink.classList.add("active")
    })
});

let categoryTable = document.querySelectorAll(".categoryRow")
let categoryBtns = document.querySelectorAll(".categoryRow button")
categoryBtns.forEach(btn => {
    btn.addEventListener('click', (e) => {
        e.composedPath()[2].children[0].children[0].readOnly = false;
        e.composedPath()[2].children[1].children[0].readOnly = false;
    })
});

