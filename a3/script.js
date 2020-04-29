let nav_height = document.getElementsByTagName('nav')[0].clientHeight
let sect1_top = document.getElementById('section1').offsetTop
let sect2_top = document.getElementById('section2').offsetTop
let sect3_top = document.getElementById('section3').offsetTop
let nav_links = document.querySelectorAll('.nav-item')

document.addEventListener('scroll', () => {
    let win_y = window.scrollY + nav_height

    if (sect1_top < win_y && win_y < sect2_top) nav_links[0].classList.add('active')
    else nav_links[0].classList.remove('active')

    if (sect2_top < win_y && win_y < sect3_top) nav_links[1].classList.add('active')
    else nav_links[1].classList.remove('active')

    if (sect3_top < win_y) nav_links[2].classList.add('active')
    else nav_links[2].classList.remove('active')
})

/* -------------------------------------------------------------- */

const synopsis = document.getElementById('synopsis')
synopsis.style.display = 'none'

/* -------------------------------------------------------------- */

const movies = {
    'movieACT': {
        name: 'Avengers: Endgame',
        rating: 'M',
        showtime: ['18:00', '-', '-', '21:00', '21:00', '21:00', '18:00'],
        plot: String.raw`After the devastating events of Avengers: Infinity War (2018), the universe is in ruins due to the efforts of the Mad Titan, Thanos. With the help of remaining allies, the Avengers must assemble once more in order to undo Thanos's actions and undo the chaos to the universe, no matter what consequences may be in store, and no matter who they face...`,
        trailer: 'https://www.youtube.com/embed/TcMBFSGVi1c'
    },
    'movieRMC': {
        name: 'Top End Wedding',
        rating: 'M',
        showtime: ['15:00', '18:00', '18:00', '-', '-', '-', '15:00'],
        plot: String.raw`Lauren and Ned are engaged, they are in love, and they have just ten days to find Lauren's mother who has gone AWOL somewhere in the remote far north of Australia, reunite her parents and pull off their dream wedding.`,
        trailer: 'https://www.youtube.com/embed/uoDBvGF9pPU'
    },
    'movieANM': {
        name: 'Dumbo',
        rating: 'PG',
        showtime: ['12:00', '12:00', '12:00', '18:00', '18:00', '18:00', '12:00'],
        plot: String.raw`Holt was once a circus star, but he went off to war and when he returned it had terribly altered him. Circus owner Max Medici (Danny DeVito) hires him to take care of Dumbo, a newborn elephant whose oversized ears make him the laughing stock of the struggling circus troupe. But when Holt's children discover that Dumbo can fly, silver-tongued entrepreneur V.A. Vandevere (Michael Keaton), and aerial artist Colette Marchant (Eva Green) swoop in to make the little elephant a star.`,
        trailer: 'https://www.youtube.com/embed/7NiYVoqBt-8'
    },
    'movieAHF': {
        name: 'The Happy Prince',
        rating: 'MA15+',
        showtime: ['21:00', '-', '-', '12:00', '12:00', '12:00', '21:00'],
        plot: String.raw`In a cheap Parisian hotel room Oscar Wilde lies on his death bed. The past floods back, taking him to other times and places. Was he once the most famous man in London? The artist crucified by a society that once worshipped him? Under the microscope of death he reviews the failed attempt to reconcile with his long suffering wife Constance, the ensuing reprisal of his fatal love affair with Lord Alfred Douglas and the warmth and devotion of Robbie Ross, who tried and failed to save him from himself. Travelling through Wilde's final act and journeys through England, France and Italy, the transience of lust is laid bare and the true riches of love are revealed. It is a portrait of the dark side of a genius who lived and died for love.`,
        trailer: 'https://www.youtube.com/embed/4HmN9r1Fcr8'
    }
}


let info = document.getElementById('info')
let movie_title = info.children[0].children[0]
let movie_rating = info.children[0].children[1]
let movie_plot = info.children[3]
let movie_input = info.children[4]
let inputs = document.querySelectorAll('input[name=\'booking\']')
let labels = document.querySelectorAll('.booking-date label')
let discount_flag = false;

const day = {
    0: 'Sunday',
    1: 'Monday',
    2: 'Tuesday',
    3: 'Wednesday',
    4: 'Thursday',
    5: 'Friday',
    6: 'Saturday'
}

const updateShowtime = movie => {
    let showtimes = movie.showtime
    let now = new Date()

    for (let i = 0; i < showtimes.length; i++) {
        const time = showtimes[i]
        const input = inputs[i]
        const label = labels[i]

        if (time === '-') {
            input.disabled = true
            input.checked = false
        }
        else input.disabled = false

        if (i <= now.getDay())
            if (time <= now.getHours())
                input.checked = !input.disabled
            else
                inputs[i + 1].checked = true



        label.innerHTML = day[i] + '<br>' + time
    }
}

let trailer = document.getElementsByTagName('iframe')[0]
let posters = document.querySelectorAll('#poster')
posters.forEach(poster => {
    poster.addEventListener('click', (e) => {
        let movie = movies[e.target.id]
        movie_title.innerHTML = movie.name
        movie_rating.innerHTML = '(' + movie.rating + ')'
        movie_plot.innerText = movie.plot
        trailer.src = movie.trailer
        movie_input.value = e.target.id
        synopsis.style.display = ''
        updateShowtime(movie)

        window.scrollTo(0, synopsis.offsetTop - nav_height)
    })
});

/* -------------------------------------------------------------- */
let total = document.getElementById('total');
let prices = {
    'FCA': [24, 30],
    'FCP': [22.5, 27],
    'FCC': [21, 24],
    'STA': [14, 19.8],
    'STP': [12.5, 17.5],
    'STC': [11, 15.3],
}

const decimalFmt = num => (Math.round(num * 100) / 100).toFixed(2)

for (const price of document.querySelectorAll('.price-special'))
    price.innerHTML = `<sup>$</sup>${decimalFmt(prices[price.classList[1]][0])}<span>*</span>`

for (const price of document.querySelectorAll('.price-normal'))
    price.innerHTML = `<sup>$</sup>${decimalFmt(prices[price.classList[1]][1])}`


const updateTotal = () => {
    let seats = [...document.getElementsByClassName('seats')].map(s => s.value ? Number(s.value) : 0)
    let temp = 0;
    if (discount_flag)
        for (let i = 0; i < 6; i++)
            temp += seats[i] * Object.values(prices)[i][0]
    else
        for (let i = 0; i < 6; i++)
            temp += seats[i] * Object.values(prices)[i][1]

    total.innerText = `Total: $${decimalFmt(temp)}`
}

let seats = document.getElementsByClassName('seats')
for (const seat of seats) seat.addEventListener('change', updateTotal)

/* -------------------------------------------------------------- */

const times = {
    '12:00': 'T12',
    '15:00': 'T15',
    '18:00': 'T18',
    '21:00': 'T21'
}

let input_divs = document.querySelectorAll('.booking-date')
for (let i = 0; i < input_divs.length; i++) {
    input_divs[i].addEventListener('click', () => {
        if (!(inputs[i].checked)) return

        let day = inputs[i].id
        let time = times[(labels[i].innerText).split('\n')[1]]
        console.log(day)
        console.log(time)
        document.querySelector('input[name=\'movie[day]\']').value = day
        document.querySelector('input[name=\'movie[hour]\']').value = time

        if (((day !== "SAT" || day !== "SUN") && time === 'T12') ||
            (day === "MON" || day === "WED"))
            discount_flag = true
        else
            discount_flag = false

        updateTotal()
    })
}

/* -------------------------------------------------------------- */

let input_name = document.querySelector('.booking-box #name')
input_name.addEventListener('blur', () => {
    if (/^[a-z .\-\']+[a-z.\-\']$/i.test(input_name.value))
        input_name.style.borderBottom = '5px solid black'
    else
        input_name.style.borderBottom = '5px solid red'
})

let input_email = document.querySelector('.booking-box #email')
input_email.addEventListener('blur', () => {
    if (input_email.validity.valid)
        input_email.style.borderBottom = '5px solid black'
    else
        input_email.style.borderBottom = '5px solid red'
})

let input_mobile = document.querySelector('.booking-box #mobile')
input_mobile.addEventListener('blur', () => {
    if (/^[0-9 ]+$/.test(input_mobile.value))
        input_mobile.style.borderBottom = '5px solid black'
    else
        input_mobile.style.borderBottom = '5px solid red'
})

let input_credit = document.querySelector('.booking-box #credit')
input_credit.addEventListener('blur', () => {
    if (/^[0-9 ]{14,19}$/.test(input_credit.value))
        input_credit.style.borderBottom = '5px solid black'
    else
        input_credit.style.borderBottom = '5px solid red'
})

let input_expiry = document.querySelector('.booking-box #expiry')
input_expiry.addEventListener('blur', () => {
    let date = (document.querySelector('input#expiry').value).split('-')
    let year = date[0]
    let month = date[1]
    let now = new Date()
    if (year >= now.getFullYear() && month > now.getMonth())
        input_expiry.style.borderBottom = '5px solid black'
    else
        input_expiry.style.borderBottom = '5px solid red'
})
