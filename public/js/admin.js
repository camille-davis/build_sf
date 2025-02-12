const csrf = document.querySelector('meta[name="csrf-token"]').content

// _Admin UI

const activate = (container) => {
  container.classList.remove('initial')

  const save = container.querySelector('.save')
  save.title = 'save'
  save.innerHTML = '<i class="fas fa-check"></i>'
  save.firstElementChild.classList.remove('loading')

  const pellContent = container.querySelectorAll('.pell-content')
  if (pellContent) {
    pellContent.forEach((editor) => {
      editor.setAttribute('contenteditable', 'true')
    })
  }

  const title = container.querySelector('.title')
  if (title) {
    title.setAttribute('contenteditable', 'true')
  }

  const tabbable = []
  tabbable.push(...container.querySelectorAll('input'))
  tabbable.push(...container.querySelectorAll('button'))
  tabbable.push(...container.querySelectorAll('select'))
  tabbable.forEach((element) => {
    element.tabIndex = ''
  })
}

const deactivate = (container) => {
  container.classList.add('initial')
  container.style = ''

  const save = container.querySelector('.save')
  save.title = 'edit'
  save.firstElementChild.classList.remove('loading')
  if (container.classList.contains('section')) {
    save.innerHTML = '<i class="fas fa-pencil-alt"></i>'
  } else {
    save.innerHTML = '<i class="fas fa-cog"></i>'
  }

  const pellContent = container.querySelectorAll('.pell-content')
  if (pellContent) {
    pellContent.forEach((editor) => {
      editor.setAttribute('contenteditable', 'false')
    })
  }

  const title = container.querySelector('.title')
  if (title) {
    title.setAttribute('contenteditable', 'false')
  }

  container.querySelectorAll('.fixed').forEach((element) => {
    element.classList.remove('fixed')
  })

  const tabbable = []
  tabbable.push(...container.querySelectorAll('input'))
  tabbable.push(...container.querySelectorAll('button'))
  tabbable.push(...container.querySelectorAll('.button'))
  tabbable.push(...container.querySelectorAll('select'))
  tabbable.forEach((element) => {
    if (element.classList.contains('save')) {
      return
    }
    element.tabIndex = '-1'
  })
}

let navHeight, sectionActionsHeight

const updateHeights = (container) => {
  const nav = document.getElementById('nav')
  if (nav) {
    rawHeight = getComputedStyle(document.documentElement).getPropertyValue('--nav-height')
    rawHeightInt = rawHeight.match(/\d+/)
    if (rawHeightInt) {
      navHeight = parseInt(rawHeightInt[0])
    }
    if ((rawHeightInt) && (rawHeight.match('rem'))) {
      navHeight *= 10
    }
  }
  if ((!container) || (!container.querySelector('.actions'))) {
    return
  }
  const actions = container.querySelector('.actions')
  sectionActionsHeight = parseInt(getComputedStyle(actions).getPropertyValue('height').match(/\d+/)[0])
}

const toggleFixed = (section) => {
  if (section.classList.contains('initial')) {
    return
  }

  actions = section.querySelector('.actions')
  pellContent = section.querySelector('.pell-content')
  pellActionBar = section.querySelector('.pell-actionbar')

  const bottomLimit = 123 + navHeight

  if ((section.getBoundingClientRect().bottom < bottomLimit) || (section.getBoundingClientRect().top > navHeight)) {
    actions.classList.remove('fixed')
    section.style = ''
    pellContent.classList.remove('fixed')
    pellActionBar.classList.remove('fixed')
    return
  }

  actions.classList.add('fixed')
  section.style.paddingTop = sectionActionsHeight + 'px'

  pellEditor = section.querySelector('.pell-editor')

  if (pellEditor.getBoundingClientRect().top > (navHeight + sectionActionsHeight)) {
    pellActionBar.classList.remove('fixed')
    pellContent.classList.remove('fixed')
    return
  }

  pellActionBar.classList.add('fixed')
  pellContent.classList.add('fixed')
}

const openPrompt = (element) => {
  element.classList.add('active')
  const firstChild = element.querySelector('input') ?? element.querySelector('.confirm')
  if (!firstChild) {
    return
  }
  firstChild.focus()
}

const closePrompt = (element) => {
  if (selectedID) {
    selectedID = null
  }

  const close = () => {
    if (element.id == 'update-media') {
      const form = element.querySelector('form')
      const save = element.querySelector('.save')
      form.setAttribute('action', '')
      save.innerHTML = 'Save'
    }

    element.querySelectorAll('input').forEach(function (input) {
      if ((input.name == '_token') || (input.name == '_method')) {
        return
      }
      input.value = ''
    })
    element.querySelectorAll('select').forEach(function (input) {
      input.value = ''
    })
    element.querySelectorAll('.selected').forEach((el) => {
      el.classList.remove('selected')
    })

    element.classList.remove('active')
    element.style.opacity = ''

    if (element.id == 'media-library') {
      const gallery = element.querySelector('.gallery')
      const loaded = gallery.querySelectorAll('li')
      for (let i = 0; i < loaded.length; i++) {
        loaded[i].remove()
      }
      gallery.querySelector('.loading-box').style.display = ''
      element.querySelector('.select').remove()
    }

    element.removeEventListener('transitionend', close)
  }

  element.style.opacity = 0
  element.addEventListener('transitionend', close)
}

/* const printError = (sectionId, str) => {

    const container = document.getElementById(`section-${sectionId}`).querySelector('.errors');
    const errors = container.querySelectorAll('.error');

    for (let i = 0; i < errors.length; i++) {
        if (errors[i].innerHTML === str) {
            return;
        }
    }

    const error = document.createElement('P');
    error.className = 'error initial';
    error.innerHTML = str;
    container.appendChild(error);
    requestAnimationFrame(() => {
        setTimeout(() => {
        error.classList.remove('initial');
        })
    });

} */

// _CRUD

const strip = (html) => {
  const tmp = document.createElement('DIV')
  tmp.innerHTML = html
  return tmp.textContent || tmp.innerText
}

const send = (form) => {
  const methodInput = form.querySelector('input[name="_method"]')
  let method
  if (!methodInput) {
    method = form.method
  } else {
    method = methodInput.value
  }

  const payload = {}
  const inputs = []
  inputs.push(...form.querySelectorAll('input'))
  inputs.push(...form.querySelectorAll('select'))
  inputs.push(...form.querySelectorAll('textarea'))
  inputs.forEach((input) => {
    if (input.type === 'hidden') {
      return
    }

    if (input.name == 'title') {
      input.value = strip(input.value)
    }

    payload[input.name] = input.value
  })

  const xhr = new XMLHttpRequest()
  xhr.open(method, form.action)
  xhr.setRequestHeader('X-CSRF-TOKEN', csrf)
  xhr.setRequestHeader('Content-Type', 'application/json')
  xhr.send(JSON.stringify(payload))

  return xhr
}

// Section

const moveSectionUp = (e, container) => {
  e.preventDefault()

  const up = container.querySelector('.up')
  up.innerHTML = '<i class="fas fa-circle-notch"></i>'
  up.firstChild.classList.add('loading')

  const form = e.currentTarget.closest('form')
  const xhr = send(form)
  xhr.onreadystatechange = () => {
    if (xhr.readyState === 4) {
      up.innerHTML = '<i class="fas fa-arrow-up"></i>'
      up.firstChild.classList.remove('loading')

      if (xhr.status !== 200) {
        return
      }

      container.parentNode.insertBefore(container, container.previousElementSibling)

      const sectionID = container.id.match(/\d+/)[0]
      const link = document.getElementById(`link-section-${sectionID}`)
      if (!link) {
        return
      }
      document.getElementById('links').insertBefore(link, link.previousElementSibling)
    }
  }
}

const moveSectionDown = (e, container) => {
  e.preventDefault()

  const down = container.querySelector('.down')
  down.innerHTML = '<i class="fas fa-circle-notch"></i>'
  down.firstChild.classList.add('loading')

  const form = e.currentTarget.closest('form')
  const xhr = send(form)
  xhr.onreadystatechange = () => {
    if (xhr.readyState === 4) {
      down.innerHTML = '<i class="fas fa-arrow-down"></i>'
      down.firstChild.classList.remove('loading')

      if (xhr.status !== 200) {
        return
      }

      container.parentNode.insertBefore(container, container.nextElementSibling.nextElementSibling)
      // TODO dont let it go below footer lmao

      const sectionID = container.id.match(/\d+/)[0]
      const link = document.getElementById(`link-section-${sectionID}`)
      if (!link) {
        return
      }
      document.getElementById('links').insertBefore(link, link.nextElementSibling.nextElementSibling)
    }
  }
}

const discardSection = (selectedID) => {
  const confirmDelete = document.getElementById('discard-section-prompt')
  const confirmButton = confirmDelete.querySelector('.confirm')

  confirmButton.innerHTML = '<i class="fas fa-circle-notch"></i>'
  confirmButton.firstChild.classList.add('loading')

  const section = document.getElementById(`section-${selectedID}`)
  const form = section.querySelector('form.discard-section')

  const xhr = send(form)
  xhr.onreadystatechange = () => {
    if (xhr.readyState === 4) {
      confirmButton.innerHTML = 'Confirm'
      if (xhr.status !== 200) {
        closePrompt(confirmDelete)
        return
      }

      document.getElementById(`section-${selectedID}`).remove()
      const link = document.getElementById(`link-section-${selectedID}`)
      if (link) {
        link.remove()
      }
      closePrompt(confirmDelete)
    }
  }
}

// _Pell Editor

const buildPell = (container) => { // called in section loop
  const stringID = container.id

  const toSend = document.getElementById(`${stringID}-to-send`)
  const pellEditor = document.getElementById(`${stringID}-pell`)

  pell.init({
    element: pellEditor,
    defaultParagraphSeparator: 'p',
    actions: [
      'bold',
      'italic',
      {
        name: 'heading1',
        title: 'Heading 1',
        icon: 'H1',
        result: function () {
          window.pell.exec('formatBlock', '<H1>')
        }
      },
      {
        name: 'heading2',
        title: 'Heading 2',
        icon: 'H2',
        result: function () {
          window.pell.exec('formatBlock', '<H2>')
        }
      },
      {
        name: 'heading3',
        title: 'Heading 3',
        icon: 'H3',
        result: function () {
          window.pell.exec('formatBlock', '<H3>')
        }
      },
      {
        name: 'paragraph',
        title: 'Paragraph',
        icon: '<span>¶</span>',
        result: function () {
          window.pell.exec('formatBlock', '<P>')
        }
      },
      'ulist',
      'olist',
      {
        name: 'link',
        title: 'Link',
        icon: '<i class="fas fa-link"></i>',
        result: function () {
          showLinkPrompt(pellEditor)
        }
      },
      {
        name: 'image',
        title: 'Image',
        icon: '<i class="far fa-image"></i>',
        result: function () {
          showImgPrompt(pellEditor)
        }
      },
      {
        name: 'youtube',
        title: 'Youtube',
        icon: '<i class="fab fa-youtube"></i>',
        result: function () {
          showVideoPrompt(pellEditor)
        }
      }
    ],
    onChange: function (html) {
      toSend.innerHTML = ''
      toSend.innerText += html
    }
  })

  const pellContent = container.querySelector('.pell-content')

  pellContent.innerHTML = toSend.value
  toSend.style.display = 'none'
  pellEditor.style.display = 'block'

  pellContent.setAttribute('contenteditable', 'false')
}

const buildEditor = (container) => {
  const titleInput = container.querySelector('input[name="title"]')
  titleInput.style.display = 'none'

  const title = container.querySelector('.title')
  title.addEventListener('input', () => {
    titleInput.setAttribute('value', title.innerHTML)
  })

  deactivate(container)
  buildPell(container)
}

let range = null

// _Pell Editor: Link

const showLinkPrompt = (pellEditor) => {
  const pellContent = pellEditor.querySelector('.pell-content')
  range = window.getSelection().getRangeAt(0)

  // Make sure cursor is in editor.
  const mother = range.commonAncestorContainer
  if ((mother !== pellContent) && (!pellContent.contains(mother))) {
    return
  }

  // If accidentally selected end of previous container, move to next.
  if (range.startOffset >= range.startContainer.length) {
    if (range.startContainer.nextElementSibling) {
      range.setStart(range.startContainer.nextElementSibling, 0)
    } else {
      range.setStart(range.startContainer.parentElement.nextElementSibling.firstChild, 0)
    }
  }

  const linkPrompt = document.getElementById('link-prompt')
  const linkText = linkPrompt.querySelector('[name="link-text"]')
  const linkURL = linkPrompt.querySelector('[name="link-url"]')

  // If editing an existing link select the whole link.
  let existingLink
  const possibleLinks = [
    range.startContainer,
    range.startContainer.parentElement,
    range.commonAncestorContainer.childNodes[range.startOffset],
    range.commonAncestorContainer.parentElement,
    range.commonAncestorContainer.parentElement.parentElement
  ]
  for (i = 0; i < possibleLinks.length; i++) {
    if ((!possibleLinks[i]) || (possibleLinks[i].tagName !== 'A')) {
      continue
    }
    existingLink = possibleLinks[i]
    break
  }
  if (existingLink) {
    linkText.value = existingLink.innerHTML
    linkURL.value = existingLink.getAttribute('href')

    range.setStart(existingLink, 0)
    if (!range.startContainer.lastChild.innerText) {
      range.setEnd(range.startContainer.lastChild, range.startContainer.lastChild.nodeValue.length - 1)
    } else {
      range.setEnd(range.startContainer.lastChild, 0)
    }

    openPrompt(linkPrompt)
    return
  }

  // If nothing selected just show the prompt.
  if ((range.startContainer === range.endContainer) &&
    (range.startOffset === range.endOffset)) {
    openPrompt(linkPrompt)
    return
  }

  // If multiple containers selected grab all of them
  if (!range.startContainer.contains(range.endContainer)) {
    range.setStart(range.startContainer, 0)
    range.setEnd(range.endContainer, range.endContainer.length)
  }

  // Populate with the range text and show prompt.
  const frag = range.cloneContents()
  const el = document.createElement('P')
  el.appendChild(frag.cloneNode(true))
  linkText.value = el.innerHTML
  openPrompt(linkPrompt)
}

const insertLink = () => {
  const linkPrompt = document.getElementById('link-prompt')
  const linkText = linkPrompt.querySelector('[name="link-text"]')
  const linkURL = linkPrompt.querySelector('[name="link-url"]')

  if ((linkText.value === '') || (linkText.value === ' ')) {
    linkText.value = linkURL.value
  }
  if (!linkURL.value.match(/^(http|\/|#|mailto:)/i)) {
    linkURL.value = '/' + linkURL.value
  }

  // Insert a new link, or replace existing one.
  const newLink = document.createElement('A')
  newLink.href = linkURL.value
  newLink.appendChild(range.createContextualFragment(linkText.value))
  if (range.commonAncestorContainer.tagName === 'A') { // if in existing link
    range.commonAncestorContainer.remove()
  }
  range.deleteContents()
  range.insertNode(newLink)

  // Update the data in the textarea.
  const pellContent = range.commonAncestorContainer.closest('.pell-content')
  const container = pellContent.closest('.block') ?? pellContent.closest('.container')
  const stringID = container.id
  const toSend = document.getElementById(`${stringID}-to-send`)
  toSend.innerHTML = pellContent.innerHTML

  closePrompt(linkPrompt)
}

const removeLink = () => {
  if (range.commonAncestorContainer.tagName !== 'A') {
    return
  }

  const linkPrompt = document.getElementById('link-prompt')
  const linkText = linkPrompt.querySelector('[name="link-text"]')

  range.commonAncestorContainer.remove()
  range.insertNode(range.createContextualFragment(linkText.value))

  // Update the data in the textarea.
  const pellContent = range.commonAncestorContainer.closest('.pell-content')
  const container = pellContent.closest('.block') ?? pellContent.closest('.container')
  const stringID = container.id
  const toSend = document.getElementById(`${stringID}-to-send`)

  pellContent.normalize()
  toSend.innerHTML = pellContent.innerHTML

  closePrompt(linkPrompt)
}

const addLinkPromptListeners = () => {
  const linkPrompt = document.getElementById('link-prompt')

  const linkInsert = linkPrompt.querySelector('.insert')
  linkInsert.onclick = () => {
    insertLink()
  }

  const unlink = linkPrompt.querySelector('.unlink')
  unlink.onclick = () => {
    removeLink()
  }

  const inputs = []
  inputs.push(...linkPrompt.querySelectorAll('input'))
  inputs.push(...linkPrompt.querySelectorAll('select'))
  inputs.push(linkInsert)
  inputs.forEach((element) => {
    element.addEventListener('keydown', (e) => {
      if (e.key === 'Enter') {
        insertLink()
      }
    })
  })
}

// _Pell Editor: Img

const showImgPrompt = (pellEditor) => {
  // Make sure cursor is in editor.
  const pellContent = pellEditor.querySelector('.pell-content')
  range = window.getSelection().getRangeAt(0)
  const mother = range.commonAncestorContainer.parentNode
  if ((mother !== pellContent) && (!pellContent.contains(mother))) {
    return
  }

  const imgPrompt = document.getElementById('img-prompt')
  const imgURL = imgPrompt.querySelector('[name="image-url"]')
  const imgAlt = imgPrompt.querySelector('[name="image-alt"]')
  const imgSize = imgPrompt.querySelector('[name="image-size"]')
  const imgPlacement = imgPrompt.querySelector('[name="image-placement"]')

  const existingImg = range.startContainer.childNodes[range.startOffset]

  // If adding a new image just show the prompt.
  if ((!existingImg) || (existingImg.tagName !== 'IMG')) {
    openPrompt(imgPrompt)
    return
  }

  // Otherwise populate it with existing image data.
  const initialClasses = existingImg.className
  let initialSize = initialClasses.match(/small|medium|large|third|half|fullwidth|original/i)
  if (initialSize) {
    initialSize = initialSize[0]
  }
  let initialPlacement = initialClasses.match(/left|right|center|inline/i)
  if (initialPlacement) {
    initialPlacement = initialPlacement[0]
  }
  imgURL.value = existingImg.getAttribute('src')
  imgAlt.value = existingImg.alt
  imgSize.value = initialSize
  imgPlacement.value = initialPlacement

  openPrompt(imgPrompt)
}

const showMediaLibrary = (multiple = false, dest = null, projectID = null) => {
  const mediaLibrary = document.getElementById('media-library')
  const gallery = mediaLibrary.querySelector('.gallery')
  const loading = mediaLibrary.querySelector('.loading-box')
  openPrompt(mediaLibrary)

  const xhr = new XMLHttpRequest()
  if (projectID) {
    xhr.open('GET', `/admin/media-data/project/${projectID}`)
  } else {
    xhr.open('GET', '/admin/media-data')
  }
  xhr.send('')
  xhr.onreadystatechange = function () {
    if (xhr.readyState !== 4) {
      return
    }
    loading.style.display = 'none'
    const media = JSON.parse(xhr.response)
    media.forEach((item) => {
      const li = document.createElement('LI')
      const img = document.createElement('IMG')

      const rawFilename = item.filename.split('.')
      img.src = `/storage/media/${rawFilename[0]}_thumb.${rawFilename[1]}`

      img.alt = item.alt
      img.id = 'image-' + item.id
      const a = document.createElement('A')
      a.classList.add('selector')
      const div = document.createElement('DIV')
      div.classList.add('button')
      div.innerHTML = '<i class="fas fa-check"></i>'

      a.appendChild(div)
      li.appendChild(img)
      li.appendChild(a)
      gallery.appendChild(li)

      a.addEventListener('click', () => {
        markAsSelected(a, multiple)
      })
      a.addEventListener('keydown', () => {
        markAsSelected(a, multiple)
      })
    })

    if (!dest) {
      return
    }
    if (dest.name == 'image_ids') {
      const arrayIDs = dest.value.split(' ')
      if (!arrayIDs[0]) {
        return
      }
      for (i = 0; i < arrayIDs.length; i++) {
        const img = mediaLibrary.querySelector(`#image-${arrayIDs[i]}`)
        const link = img.nextElementSibling
        link.classList.add('selected')
        link.querySelector('.button').innerHTML = i
      }
    }
  }

  const selectButton = document.createElement('BUTTON')
  selectButton.className = 'select'
  selectButton.innerHTML = 'Select'
  selectButton.addEventListener('click', (e) => {
    e.preventDefault()
    selectMedia(dest)
  })

  mediaLibrary.querySelector('.prompt').append(selectButton)
}

const markAsSelected = (link, multiple) => {
  const gallery = link.closest('.gallery')
  const selected = gallery.querySelectorAll('.selected')

  if (!multiple) {
    if (link.classList.contains('selected')) {
      link.classList.remove('selected')
      return
    }
    selected.forEach((a) => {
      a.classList.remove('selected')
    })
    link.classList.add('selected')
    return
  }

  const arraySelected = Array.prototype.slice.call(selected, 0)

  if (!link.classList.contains('selected')) {
    link.classList.add('selected')
    link.querySelector('.button').innerHTML = arraySelected.length
    return
  }

  arraySelected.sort((a, b) => {
    const aPosition = parseInt(a.querySelector('.button').innerHTML)
    const bPosition = parseInt(b.querySelector('.button').innerHTML)
    if (aPosition > bPosition) {
      return 1
    }
    if (aPosition < bPosition) {
      return -1
    }
    return 0
  })

  const button = link.querySelector('.button')
  for (i = parseInt(button.innerHTML) + 1; i < arraySelected.length; i++) {
    arraySelected[i].querySelector('.button').innerHTML -= 1
  }
  button.innerHTML = '<i class="fas fa-check"></i>'
  link.classList.remove('selected')
}

const selectMedia = (dest) => {
  const mediaLibrary = document.getElementById('media-library')
  const selected = mediaLibrary.querySelectorAll('.selected')
  if (!selected[0]) {
    closePrompt(mediaLibrary)
    return
  }

  const img0 = selected[0].previousSibling

  const imgPrompt = document.getElementById('img-prompt')
  if ((imgPrompt) && (imgPrompt.classList.contains('active'))) {
    if (imgPrompt.querySelector('[name="image-url"]')) {
      imgPrompt.querySelector('[name="image-url"]').value = img0.src.replace('_thumb', '')
      imgPrompt.querySelector('[name="image-alt"]').value = img0.alt
    }

    closePrompt(mediaLibrary)
    return
  }

  if (dest == null) {
    closePrompt(mediaLibrary)
    return
  }

  if (dest.name == 'logo_url') {
    dest.setAttribute('value', img0.src)
    closePrompt(mediaLibrary)
    return
  }

  if (dest.name == 'featured_image_id') {
    dest.setAttribute('value', img0.id.match(/\d+/)[0])
    closePrompt(mediaLibrary)
    return
  }

  if (dest.name != 'image_ids') {
    closePrompt(mediaLibrary)
    return
  }

  const arraySelected = Array.prototype.slice.call(selected, 0)
  arraySelected.sort((a, b) => {
    const aPosition = parseInt(a.querySelector('.button').innerHTML)
    const bPosition = parseInt(b.querySelector('.button').innerHTML)
    if (aPosition > bPosition) {
      return 1
    }
    if (aPosition < bPosition) {
      return -1
    }
    return 0
  })

  let stringIDs = arraySelected[0].previousElementSibling.id.match(/\d+/)[0]

  for (i = 1; i < arraySelected.length; i++) {
    stringIDs += ' ' + arraySelected[i].previousElementSibling.id.match(/\d+/)[0]
  }

  dest.setAttribute('value', stringIDs)
  updateSlideshow(dest.closest('.container'))
  closePrompt(mediaLibrary)
}

const insertImg = () => {
  const imgPrompt = document.getElementById('img-prompt')
  const imgURL = imgPrompt.querySelector('[name="image-url"]')
  const imgAlt = imgPrompt.querySelector('[name="image-alt"]')
  const imgSize = imgPrompt.querySelector('[name="image-size"]')
  const imgPlacement = imgPrompt.querySelector('[name="image-placement"]')

  if (!imgURL.value) {
    closePrompt(imgPrompt)
    return
  }

  if (!imgURL.value.match(/^(http|\/|#)/i)) {
    imgURL.value = '/' + imgURL.value
  }

  // Insert a new image, or replace existing image.
  const newImg = document.createElement('IMG')
  newImg.src = imgURL.value
  newImg.alt = imgAlt.value
  newImg.classList.add(`image-${imgSize.value}`)
  newImg.classList.add(`image-${imgPlacement.value}`)
  range.deleteContents()
  range.insertNode(newImg)

  // Update the data in the textarea
  const pellContent = range.commonAncestorContainer.closest('.pell-content')
  const container = pellContent.closest('.block') ?? pellContent.closest('.container')
  const stringID = container.id
  const toSend = document.getElementById(`${stringID}-to-send`)

  pellContent.normalize()
  toSend.innerHTML = pellContent.innerHTML

  closePrompt(imgPrompt)
}

const addImgPromptListeners = () => {
  const imgPrompt = document.getElementById('img-prompt')

  const imgInsert = imgPrompt.querySelector('.insert')
  imgInsert.onclick = () => {
    insertImg()
  }

  const inputs = []
  inputs.push(...imgPrompt.querySelectorAll('input'))
  inputs.push(...imgPrompt.querySelectorAll('select'))
  inputs.push(imgInsert)
  inputs.forEach((element) => {
    element.addEventListener('keydown', (e) => {
      if (e.key === 'Enter') {
        insertImg()
      }
    })
  })

  const imgSelect = imgPrompt.querySelector('.select')
  imgSelect.onclick = () => {
    showMediaLibrary()
  }
}

// _Pell Editor: Video

const showVideoPrompt = (pellEditor) => {
  // Make sure cursor is in editor.
  const pellContent = pellEditor.querySelector('.pell-content')
  range = window.getSelection().getRangeAt(0)
  const mother = range.commonAncestorContainer.parentNode
  if ((mother !== pellContent) && (!pellContent.contains(mother))) {
    return
  }

  const videoPrompt = document.getElementById('video-prompt')
  const videoURL = videoPrompt.querySelector('[name="video-url"]')
  openPrompt(videoPrompt)
}

const insertVideo = () => {
  const videoPrompt = document.getElementById('video-prompt')
  const videoURL = videoPrompt.querySelector('[name="video-url"]')

  // create element
  const videoContainer = document.createElement('P')
  videoContainer.classList.add('video')
  const video = document.createElement('IFRAME')
  videoContainer.appendChild(video)
  video.src = videoURL.value
  range.deleteContents()
  range.insertNode(videoContainer)

  // Update the data in the textarea
  const pellContent = range.commonAncestorContainer.closest('.pell-content')
  const container = pellContent.closest('.block') ?? pellContent.closest('.container')
  const stringID = container.id
  const toSend = document.getElementById(`${stringID}-to-send`)

  pellContent.normalize()
  toSend.innerHTML = pellContent.innerHTML

  closePrompt(videoPrompt)

  /* // get the youtube id
    const regex = /^.*((youtu.be\/)|(v\/)|(\/u\/\w\/)|(embed\/)|(watch\?))\??v?=?([^#\&\?]*). */
  /* const youtubeID = youtubeURL.value.match(regex);

    // if not a valid id format then error
    if ( !youtubeID || youtubeID[7].length !== 11 ){
        e.preventDefault();
        if (youtubePrompt.querySelector('.error')) {
            return;
        }
        youtubeError = document.createElement("P");
        youtubeError.className = 'error initial';
        youtubeError.innerHTML = "Please enter a valid Youtube URL.";
        document.querySelector('#youtube .prompt').insertBefore(youtubeError, youtubeInsert)
        requestAnimationFrame(() => {
            setTimeout(() => {
            youtubeError.classList.remove('initial');
            })
        });
        return;
    }

    url = 'https://www.youtube.com/embed/' + youtubeID[7];
     */
}

const addVideoPromptListeners = () => {
  const videoPrompt = document.getElementById('video-prompt')

  const videoInsert = videoPrompt.querySelector('.insert')
  videoInsert.onclick = () => {
    insertVideo()
  }

  const inputs = []
  inputs.push(...videoPrompt.querySelectorAll('input'))
  inputs.push(videoInsert)
  inputs.forEach((element) => {
    element.addEventListener('keydown', (e) => {
      if (e.key === 'Enter') {
        insertVideo()
      }
    })
  })
}

// TODO get rid of these  idk how

let selectedID = null

let selectedItem = null

let selectedLink = null

const index = (child) => {
  return Array.prototype.indexOf.call(child.parentNode.children, child)
}

const addSectionListeners = (container) => {
  const save = container.querySelector('.save')

  container.addEventListener('transitionend', (e) => {
    if (!container.classList.contains('initial')) {
      updateHeights(container)
    }
  })

  const sectionID = container.id.match(/\d+/)[0]

  const up = container.querySelector('.up')
  up.addEventListener('click', (e) => {
    moveSectionUp(e, container)
  })

  const down = container.querySelector('.down')
  down.addEventListener('click', (e) => {
    moveSectionDown(e, container)
  })

  const discard = container.querySelector('.discard')
  discard.addEventListener('click', (e) => {
    e.preventDefault()
    openPrompt(document.getElementById('discard-section-prompt'))
    selectedID = sectionID
  })

  // Slideshow section

  if (container.getAttribute('type') == 'slideshow') {
    const select = container.querySelector('.actions .select')
    const input = container.querySelector('input[name="image_ids"]')
    select.addEventListener('click', (e) => {
      e.preventDefault()
      showMediaLibrary(true, input)
    })
  } else if (container.getAttribute('type') == 'projects') {
    const list = container.querySelector('.projects-list')
    const items = list.querySelectorAll('li')
    items.forEach((li) => {
      const a = li.querySelector('.move')
      a.addEventListener('mouseover', () => {
        li.setAttribute('draggable', 'true')
      })
      a.addEventListener('mouseout', () => {
        li.setAttribute('draggable', 'false')
      })
      li.addEventListener('dragstart', () => {
        selectedItem = li
      })
      li.addEventListener('dragover', (e) => {
        if ((!selectedItem) || (selectedItem == li)) {
          return
        }
        if (index(selectedItem) < index(li)) {
          list.insertBefore(selectedItem, li.nextElementSibling)
          return
        }
        list.insertBefore(selectedItem, li)
      })
      li.addEventListener('dragend', () => {
        selectedItem = null
      })
    })
  }
}

const addPellListeners = () => {
  addImgPromptListeners()
  addLinkPromptListeners()
  addVideoPromptListeners()
}

const addPageListeners = () => {
  const options = document.getElementById('page')
  if (options) {
    const titleInput = options.querySelector('input[name="title"]')
    titleInput.style.display = 'none'

    const title = options.querySelector('h1.page-title')
    title.addEventListener('input', () => {
      titleInput.setAttribute('value', title.innerHTML)
    })

    const discardPrompt = document.getElementById('discard-page-prompt')
    const discardForm = document.getElementById('discard-page')
    const discardButton = discardForm.querySelector('button[type="submit"]')

    discardPrompt.querySelector('.confirm').addEventListener('click', () => {
      discardForm.submit()
    })

    discardButton.addEventListener('click', (e) => {
      e.preventDefault()
      openPrompt(discardPrompt)
    })
  }

  // TODO
  const discardSectionPrompt = document.getElementById('discard-section-prompt')
  discardSectionPrompt.querySelector('.confirm').addEventListener('click', () => {
    if (!selectedID) {
      closePrompt(discardSectionPrompt)
    }
    discardSection(selectedID)
  })

  const sections = document.querySelectorAll('.section')
  sections.forEach((section) => {
    document.addEventListener('scroll', () => {
      toggleFixed(section)
    })
  })
}

const addSettingsListeners = () => {
  const select = document.querySelector('.select')
  if (select) {
    const input = document.querySelector('input[name="logo_url"]')
    select.addEventListener('click', (e) => {
      e.preventDefault()
      showMediaLibrary(false, input)
    })
  }
}

const addProjectListeners = () => {
  const project = document.querySelector('.project.container')
  document.addEventListener('scroll', () => {
    toggleFixed(project)
  })
  project.querySelector('.actions').addEventListener('transitionend', () => {
    if (!project.classList.contains('initial')) {
      updateHeights(project)
    }
  })

  const id = project.id.match(/\d+/)[0]

  const select = project.querySelector('.select')
  const input = project.querySelector('input[name="featured_image_id"]')
  select.addEventListener('click', (e) => {
    e.preventDefault()
    showMediaLibrary(false, input, id)
  })
}

const updateProjectWeights = (container) => {
  const payload = []
  const list = container.querySelector('.projects-list')
  list.querySelectorAll('li').forEach((li) => {
    const id = li.id.match(/\d+/)[0]
    payload.push(id)
  })

  const xhr = new XMLHttpRequest()
  xhr.open('PATCH', '/admin/projects/weights')
  xhr.setRequestHeader('X-CSRF-TOKEN', csrf)
  xhr.setRequestHeader('Content-Type', 'application/json')
  xhr.send(JSON.stringify(payload))
}

const addGlobalListeners = () => {
  updateHeights()
  window.addEventListener('resize', () => {
    updateHeights()
  })

  document.querySelectorAll('.prompt-container').forEach((element) => {
    element.querySelector('.close').onclick = () => {
      closePrompt(element)
    }
  })

  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') {
      document.querySelectorAll('.active.prompt-container').forEach((element) => {
        closePrompt(element)
      })
    }
  })

  const expirationPrompt = document.getElementById('expiration-prompt')
  if (expirationPrompt) {
    expirationPrompt.querySelector('.confirm').addEventListener('click', () => {
      closePrompt(expirationPrompt)
    })
  }

  document.querySelectorAll('.save').forEach((save) => {
    const container = save.closest('.container')
    const form = save.closest('form')
    save.addEventListener('click', (e) => {
      e.preventDefault()

      if (save.title === 'edit') {
        activate(container)
        return
      }

      if ((container) && (container.getAttribute('type') == 'projects')) {
        updateProjectWeights(container)
      }

      save.innerHTML = '<i class="fas fa-circle-notch"></i>'
      save.firstChild.classList.add('loading')
      const xhr = send(form)
      xhr.onreadystatechange = () => {
        if (xhr.readyState === 4) {
          if (xhr.status === 419) {
            const expirationPrompt = document.getElementById('expiration-prompt')
            openPrompt(expirationPrompt)
            if (!container) {
              return
            }
            deactivate(container)
            activate(container)
            return
          }
          if (xhr.status !== 200) {
            return
          }

          const updateMediaPrompt = document.getElementById('update-media')
          if ((updateMediaPrompt) &&
                    (updateMediaPrompt.classList.contains('active'))) {
            updateMedia(updateMediaPrompt)
            closePrompt(updateMediaPrompt)
            return
          }
          if (!container) {
            return
          }
          deactivate(container)
        }
      }
    })
  })
}

const updateMedia = (updateMediaPrompt) => {
  const form = updateMediaPrompt.querySelector('form')
  const projectIDInput = form.querySelector('input[name="project_id"]')
  const altInput = form.querySelector('input[name="alt"]')
  const save = form.querySelector('.save')

  const id = form.getAttribute('action').match(/\d+/)[0]
  const img = document.getElementById(`image-${id}-thumb`)

  img.setAttribute('alt', altInput.value)

  if (projectIDInput) {
    img.setAttribute('project_id', projectIDInput.value)
  }

  form.setAttribute('action', '')
  save.innerHTML = 'Save'
}

const updateSlideshow = (container) => {
  const stringIDs = container.querySelector('input[name="image_ids"]').value
  const slider = container.querySelector('.slider')
  slider.querySelectorAll('img').forEach((img) => {
    img.remove()
  })

  if (!stringIDs) {
    return
  }

  const xhr = new XMLHttpRequest()
  xhr.open('GET', `/admin/media-data/${stringIDs}`)
  xhr.send('')
  xhr.onreadystatechange = function () {
    if ((xhr.readyState !== 4) || (xhr.status !== 200)) {
      return
    }
    const media = JSON.parse(xhr.response)
    media.forEach((item) => {
      const img = document.createElement('IMG')
      img.id = `image-${item.id}`
      img.className = 'slide'
      img.setAttribute('lazysrc', `/storage/media/${item.filename}`)
      img.alt = item.alt
      slider.append(img)
    })
    activateSliders()
  }
}

const addMediaLibraryListeners = () => {
  const gallery = document.querySelector('.gallery')

  const updateMediaPrompt = document.getElementById('update-media')
  const form = updateMediaPrompt.querySelector('form')
  const projectIDInput = form.querySelector('input[name="project_id"]')
  const altInput = form.querySelector('input[name="alt"]')

  gallery.querySelectorAll('li').forEach((li) => {
    const edit = li.querySelector('.edit')
    const img = li.querySelector('.media-link img')

    const mediaID = img.id.match(/\d+/)[0]

    edit.addEventListener('click', (e) => {
      e.preventDefault()
      openPrompt(updateMediaPrompt)

      form.setAttribute('action', `/admin/media/${mediaID}`)

      const projectID = img.getAttribute('project_id')
      if (projectID) {
        projectIDInput.value = projectID
      }

      const alt = img.getAttribute('alt')
      if (alt) {
        altInput.value = alt
      }
    })
  })
}

const addLayoutListeners = () => {
  const nav = document.getElementById('nav')
  const itemIDs = nav.querySelector('input[name="item_ids"]')
  const links = document.getElementById('links')
  const items = links.querySelectorAll('li')
  items.forEach((li) => {
    const move = li.querySelector('.move')
    if (!move) {
      return
    }
    move.addEventListener('mouseover', () => {
      li.setAttribute('draggable', 'true')
    })
    move.addEventListener('mouseout', () => {
      li.setAttribute('draggable', 'false')
    })
    li.addEventListener('dragstart', () => {
      selectedLink = li
    })
    li.addEventListener('dragover', (e) => {
      if ((!selectedLink) || (selectedLink == li)) {
        return
      }
      if (index(selectedLink) < index(li)) {
        links.insertBefore(selectedLink, li.nextElementSibling)
        return
      }
      links.insertBefore(selectedLink, li)
    })
    li.addEventListener('dragend', () => {
      let stringIDs = ''
      const items = links.querySelectorAll('li')
      items.forEach((li) => {
        const id = li.id.match(/\d+/)[0]
        stringIDs += id + ' '
      })
      itemIDs.setAttribute('value', stringIDs)
      selectedLink = null
    })
  })
}
