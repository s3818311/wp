let checkOutBtn = document.getElementById("checkOutBtn")

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
