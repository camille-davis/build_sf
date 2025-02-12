// Custom functions

/* document.querySelectorAll('.collapsible .toggle').forEach((el) => {
    el.innerHTML = '<img src="/storage/media/60dcd51ce9349.png" />';
});

document.querySelectorAll('.prev').forEach((el) => {
    el.querySelector('i').remove();
    const img = document.createElement('IMG');

    if (el.closest('.project-navigation')) {
        img.src = '/storage/media/60e8bea15b582.png';
    } else {
        img.src = '/storage/media/60dcd51ce9349.png';
    }

    el.prepend(img);
});

document.querySelectorAll('.next').forEach((el) => {
    el.querySelector('i').remove();
    const img = document.createElement('IMG');

    if (el.closest('.project-navigation')) {
        img.src = '/storage/media/60e8bea15b582.png';
    } else {
        img.src = '/storage/media/60dcd51ce9349.png';
    }

    el.append(img);
}); */

if (document.querySelector('body.page-14')) {
  const hidePartially = (el) => {
    let children
    if (el.querySelector('.pell-content')) {
      children = el.querySelector('.pell-content').children
    } else {
      children = el.children
    }

    let isPastFirstImage = false
    for (i = 0; i < children.length; i++) {
      if (isPastFirstImage) {
        children[i].style.display = 'none'
      }
      if ((children[i].tagName == 'IMG') ||
            ((children[i].firstElementChild) && (children[i].firstElementChild.tagName == 'IMG'))) {
        isPastFirstImage = true
        children[i].style.display = 'none'
        continue
      }
    }

    /* let isPastFirstHeader = false;
        let isPastSecondHeader = false;
        for (i = 0; i < children.length; i++) {
            if (isPastSecondHeader) {
                children[i].style.display = 'none';
                continue;
            }
            if (children[i].tagName != 'H3') {
                continue;
            }
            if (isPastFirstHeader) {
                children[i].style.display = 'none';
                isPastSecondHeader = true;
                continue;
            }
            isPastFirstHeader = true;
        } */
  }

  animateCollapse = (e, el) => { // overwrite functions.js
    e.preventDefault()

    const insideEl = el.querySelector('.inside')

    let parentEl
    if (insideEl.querySelector('.pell-content')) {
      parentEl = insideEl.querySelector('.pell-content')
    } else {
      parentEl = insideEl
    }
    children = parentEl.children

    const button = e.target.closest('button')

    const reset = () => {
      insideEl.setAttribute('style', '')
      insideEl.removeEventListener('transitionend', reset)
      if (!el.classList.contains('collapsed')) {
        return
      }
      hidePartially(insideEl)
    }

    insideEl.addEventListener('transitionend', reset)

    if (el.classList.contains('collapsed')) {
      const collapsedHeight = window.getComputedStyle(el).height
      insideEl.setAttribute('style', 'height: ' + collapsedHeight)

      for (i = 0; i < children.length; i++) {
        children[i].setAttribute('style', '')
      }

      const expandedHeight = getChildrenHeight(insideEl)
      window.requestAnimationFrame(() => {
        window.setTimeout(() => {
          insideEl.setAttribute('style', 'height: ' + expandedHeight + 'px;')
        })
      })

      el.classList.remove('collapsed')
      return
    }

    const expandedHeight = window.getComputedStyle(insideEl).height
    insideEl.setAttribute('style', 'height: ' + expandedHeight)
    hidePartially(insideEl)
    const collapsedHeight = getChildrenHeight(parentEl) + parseInt(window.getComputedStyle(el.querySelector('.toggle')).height)

    for (i = 0; i < children.length; i++) {
      children[i].setAttribute('style', '')
    }

    window.requestAnimationFrame(() => {
      window.setTimeout(() => {
        insideEl.setAttribute('style', 'height: ' + collapsedHeight + 'px')
        el.classList.add('collapsed')
      })
    })
  }

  document.querySelectorAll('.section .inside').forEach((el) => {
    hidePartially(el)
  })
}

const project = document.querySelector('.project.container')
if (project) {
  const body = project.querySelector('.body')
  const slider = project.querySelector('.slider')
  const toggle = document.createElement('button')
  toggle.classList.add('toggle')
  toggle.title = 'collapse'
  body.prepend(toggle)

  toggle.addEventListener('click', (e) => {
    e.preventDefault()
    body.classList.toggle('collapsed')
  })

  const gallery = project.querySelector('.gallery')
  const slides = project.querySelectorAll('.slide')

  setPadding = () => {
    if (!window.matchMedia('(max-width:767px)').matches) {
      slider.style.transition = ''
      slider.style.paddingBottom = ''
      return
    }
    const current = getCurrentSlide(slides)
    slider.style.paddingBottom = slides[current].offsetHeight + 'px'
  }

  slides[0].addEventListener('load', () => {
    setPadding()
  })

  window.addEventListener('resize', () => {
    setPadding()
  })

  switchToSlide = (slides, upcomingSlide, smooth) => {
    const current = getCurrentSlide(slides)

    if ((!slides[current]) || (!slides[current].complete) || (!upcomingSlide.complete) || (slides[current] == upcomingSlide)) {
      return
    }

    const reset = () => {
      upcomingSlide.removeEventListener('transitionend', reset)
      slides[current].style.transition = ''
      upcomingSlide.style.transition = ''
      slider.style.transition = ''
    }

    upcomingSlide.addEventListener('transitionend', reset)

    slides[current].style.zIndex = 0
    upcomingSlide.style.zIndex = 1

    if (window.matchMedia('(max-width:767px)').matches) {
      slider.style.paddingBottom = slides[current].offsetHeight + 'px'
    }

    if (smooth) {
      slides[current].style.transition = 'opacity 2s'
      upcomingSlide.style.transition = 'opacity 2s'
      if (window.matchMedia('(max-width:767px)').matches) {
        slider.style.transition = 'padding-bottom 2s'
      }
    } else {
      if (window.matchMedia('(max-width:767px)').matches) {
        slider.style.transition = 'padding-bottom .4s'
      }
      slides[current].style.transition = ''
      upcomingSlide.style.transition = ''
    }

    window.requestAnimationFrame(() => {
      window.setTimeout(() => {
        upcomingSlide.classList.remove('hidden')
        slides[current].classList.add('hidden')
        if (!window.matchMedia('(max-width:767px)').matches) {
          return
        }
        slider.style.paddingBottom = upcomingSlide.offsetHeight + 'px'
      })
    })
  }

  gallery.querySelectorAll('.media-link').forEach((link) => {
    link.addEventListener('click', (e) => {
      e.preventDefault()
      img = link.querySelector('img')
      id = img.id.match(/\d+/)[0]
      slide = project.querySelector(`#image-${id}`)
      switchToSlide(slides, slide, false)
      if (!window.matchMedia('(max-width:767px)').matches) {

      }
      // window.scrollTo(0, 0);
    })
  })
}
