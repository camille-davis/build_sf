const changeNavOpacity = (nav, r, g, b) => {
  const firstSection = document.querySelector('.section')

  const scrollTop = window.pageYOffset || (document.documentElement || document.body.parentNode || document.body).scrollTop

  if (scrollTop > window.innerHeight) {
    nav.style.backgroundColor = 'rgba(' + r + ',' + g + ',' + b + ',1)'
    return
  }

  nav.style.backgroundColor = 'rgba(' + r + ',' + g + ',' + b + ',' + (scrollTop / window.innerHeight) + ')'
}

const transparentNav = () => {
  // Get nav background as rgb

  const nav = document.getElementById('nav')
  let bg = window.getComputedStyle(nav).backgroundColor
  bg = bg.replace(/[^\d,]/g, '').split(',')
  const r = bg[0]
  const g = bg[1]
  const b = bg[2]

  // change the 1st element based on position of 2nd element
  changeNavOpacity(nav, r, g, b)
  window.addEventListener('scroll', () => {
    changeNavOpacity(nav, r, g, b)
  })
  window.addEventListener('resize', () => {
    changeNavOpacity(nav, r, g, b)
  })
}

const dropdownNav = () => {
  toggle = document.getElementById('toggle')
  links = document.getElementById('links')
  nav = document.querySelector('nav')

  toggle.classList.add('visible')

  link = links.querySelectorAll('a')
  for (let i = 0; i < link.length; i++) {
    link[i].addEventListener('click', toggleMenu)
  }

  toggle.querySelector('button').addEventListener('click', toggleMenu)

  const resetMenu = () => {
    if (window.matchMedia('max-width: 767px').matches) {
      return
    }
    nav.classList.remove('open')
    toggle.querySelector('button').classList.remove('is-active')
  }

  function toggleMenu () {
    toggle.querySelector('button').classList.toggle('is-active')
    nav.classList.toggle('open')
  }

  window.addEventListener('resize', () => {
    resetMenu()
  })
}

/* Slideshow */

const getCurrentSlide = (slides) => {
  let current
  for (i = 0; i < slides.length; i++) {
    if (slides[i].classList.contains('hidden')) {
      continue
    }
    current = i
  }

  if (!current) {
    current = 0
  }

  return current
}

const switchToSlide = (slides, upcomingSlide, smooth) => {
  const current = getCurrentSlide(slides)

  if ((!slides[current]) || (!slides[current].complete) || (!upcomingSlide.complete) || (slides[current] == upcomingSlide)) {
    return
  }

  const reset = () => {
    upcomingSlide.removeEventListener('transitionend', reset)
    slides[current].style.transition = ''
    upcomingSlide.style.transition = ''
  }

  upcomingSlide.addEventListener('transitionend', reset)

  slides[current].style.zIndex = 0
  upcomingSlide.style.zIndex = 1

  if (smooth) {
    slides[current].style.transition = 'opacity 2s'
    upcomingSlide.style.transition = 'opacity 2s'
  } else {
    slides[current].style.transition = ''
    upcomingSlide.style.transition = ''
  }

  window.requestAnimationFrame(() => {
    window.setTimeout(() => {
      upcomingSlide.classList.remove('hidden')
      slides[current].classList.add('hidden')
    })
  })
}

const showNextSlide = (slides, smooth) => {
  const current = getCurrentSlide(slides)

  let next
  if (current < slides.length - 1) {
    next = current + 1
  } else {
    next = 0
  }

  switchToSlide(slides, slides[next], smooth)
}

const showPreviousSlide = (slides, smooth) => {
  const current = getCurrentSlide(slides)

  let previous
  if (current > 0) {
    previous = current - 1
  } else {
    previous = slides.length - 1
  }

  switchToSlide(slides, slides[previous], smooth)
}

const activateSliders = () => {
  document.querySelectorAll('.slider').forEach((slider) => {
    slider.classList.add('active')
    const slides = slider.querySelectorAll('.slide')
    for (let i = 0; i < slides.length; i++) {
      slides[i].classList.add('hidden')
      slides[i].src = slides[i].getAttribute('lazysrc')
      slides[i].addEventListener('load', () => {
        const width = slides[i].getBoundingClientRect().width
        const height = slides[i].getBoundingClientRect().height
        if (width / height < 1) {
          slides[i].classList.add('narrow')
        }
        if (i !== 0) {
          return
        }
        slides[i].classList.remove('hidden')
      })
    }

    const existingPrev = slider.querySelector('.prev')
    if (existingPrev) {
      existingPrev.remove()
    }
    const prev = document.createElement('A')
    prev.className = 'arrow prev'
    prev.href = '#'
    prev.innerHTML = '<i class="fas fa-chevron-left"></i>'
    prev.addEventListener('click', (e) => {
      e.preventDefault()
      showPreviousSlide(slides, false)
    })
    slider.prepend(prev)

    const existingNext = slider.querySelector('.next')
    if (existingNext) {
      existingNext.remove()
    }
    const next = document.createElement('A')
    next.className = 'arrow next'
    next.href = '#'
    next.innerHTML = '<i class="fas fa-chevron-right"></i>'
    next.addEventListener('click', (e) => {
      e.preventDefault()
      showNextSlide(slides, false)
    })
    slider.append(next)

    window.setInterval(() => {
      if ((document.activeElement == prev) ||
            (document.activeElement == next) ||
            (document.activeElement.classList.contains('media-link'))) {
        return
      }
      showNextSlide(slides, true)
    }, 6000)
  })
}

/* Collapsible Sections */

const getChildrenHeight = (el) => {
  let height = 0
  for (let i = 0; i < el.children.length; i++) {
    const style = window.getComputedStyle(el.children[i])
    if (style.display == 'none') {
      continue
    }
    height += parseInt(style.height) + parseInt(style.marginTop) + parseInt(style.marginBottom)
  }

  return height
}

/* Collapsible Elements */

const animateCollapse = (e, el) => {
  e.preventDefault()

  const inside = el.querySelector('.inside')
  const button = e.target.closest('button')
  const height = getChildrenHeight(el.querySelector('.inside'))

  const reset = () => {
    inside.setAttribute('style', '')
    inside.removeEventListener('transitionend', reset)
  }

  inside.addEventListener('transitionend', reset)

  if (el.classList.contains('collapsed')) {
    inside.setAttribute('style', 'height: ' + height + 'px;')
    el.classList.remove('collapsed')
    return
  }

  inside.setAttribute('style', 'height: ' + height + 'px;')
  window.requestAnimationFrame(() => {
    window.setTimeout(() => {
      inside.setAttribute('style', '')
      el.classList.add('collapsed')
    })
  })
}

const activateCollapsible = () => {
  document.querySelectorAll('.collapsible').forEach((el) => {
    el.classList.add('collapsed')

    const button = document.createElement('BUTTON')
    button.innerHTML = '<i class="fas fa-chevron-up"></i>'
    button.classList.add('toggle')
    button.title = 'expand'
    el.prepend(button)

    button.addEventListener('click', (e) => {
      animateCollapse(e, el)
    })
  })
}

const addCaptchaError = (form) => {
  form.addEventListener('submit', function (e) {
    if (this.querySelector('.g-recaptcha-response').value === '') {
      e.preventDefault()
      if (this.querySelector('.captcha-error')) { return }
      const captchaError = document.createElement('P')
      captchaError.className = 'error captcha-error initial'
      captchaError.setAttribute('role', 'alert')
      captchaError.innerHTML = 'Please complete the Captcha.'
      this.insertBefore(captchaError, this.querySelector('.g-recaptcha'))
      requestAnimationFrame(() => {
        setTimeout(() => {
          captchaError.classList.remove('initial')
        })
      })
    }
  })
}
