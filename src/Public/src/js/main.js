/**
 * Form Modal
 */

class FormModal {

    constructor(data) {
        this.data = data
    }

    _buildInputs() {
        return this.data?.form?.inputs.map(d => {
            const label = document.createElement('label')
            label.append(d.label || '')
            switch (d.type) {
                case 'select':
                    const select = document.createElement('select')
                    d.options.forEach(o => {
                        const option = document.createElement('option')
                        option.value = o.value
                        option.selected = o.selected
                        option.append(o.name)
                        select.append(option)
                    })
                    select.name = d.name
                    select.autocomplete = "off"
                    return [label, select]
                case 'radio':
                    const radio = document.createElement('input')
                    radio.id = d.value
                    radio.type = d.type
                    radio.name = d.name
                    radio.checked = d.checked
                    radio.value = d.value || ''
                    radio.autocomplete = "off"
                    if (d.checked) {
                        radio.checked = true
                    }
                    const div = document.createElement('div')
                    div.classList.add('bb-margin-medium-top-bottom', 'flex')
                    label.htmlFor = d.value
                    div.append(radio)
                    div.append(label)
                    return div
                default:
                    const input = document.createElement('input')
                    input.type = d.type
                    input.name = d.name
                    input.checked = d.checked
                    input.min = d.min
                    input.value = d.value || ''
                    input.autocomplete = "off"
                    return [label, input]
            }
        }).flat()
    }

    _buildForm(htmlInputs) {
        const form = document.createElement('form')
        htmlInputs.forEach(input => {
            form.append(input)
        })
        const submit = document.createElement('input')
        submit.type = "submit"
        submit.value = this.data?.form?.submit
        form.append(submit)
        form.method = this.data?.form?.method
        if (isStartBySlash(this.data?.form?.action)) {
            form.action = this.data?.form?.action
        } else {
            form.action = this.data?.form?.action ? `${window.location.pathname}/${this.data?.form?.action}` : window.location.pathname
        }
        return form
    }

    _buildTitle() {
        const title = this.data?.title
        const h2 = document.createElement('h2')
        h2.append(title)
        return h2
    }

    _buildModal() {
        const htmlInputs = this._buildInputs()
        const form = this._buildForm(htmlInputs)
        const h2 = this._buildTitle()

        const modal = document.createElement('div')
        const formModal = document.createElement('div')
        const nav = document.createElement('nav')
        const closeButton = document.createElement('button')
        const closeButtonBox = document.createElement('div')
        closeButtonBox.addEventListener('click', () => this.close())
        closeButtonBox.append(closeButton)
        nav.append(h2)
        nav.append(closeButtonBox)
        formModal.append(nav)
        formModal.append(form)
        formModal.classList.add('form-modal')

        modal.append(formModal)
        modal.classList.add('modal')

        return modal
    }

    open() {
        const body = document.querySelector('body')
        this.modal = this._buildModal()
        body.append(this.modal)
    }

    close() {
        this.modal.remove()
    }
}

class YesNoModal {

    constructor(data) {
        this.data = data
    }

    _buildHiddenInput() {
        const { name, value } = this.data?.form?.input
        const input = document.createElement('input')
        input.type = 'hidden'
        input.name = name
        input.value = value
        return input
    }

    _buildCsrf() {
        const csrf = document.createElement('input')
        csrf.type = 'hidden'
        csrf.name = 'csrf'
        csrf.value = this.data.form.csrf
        return csrf
    }

    _buildNoBtn() {
        const noBtn = document.createElement('input')
        noBtn.type = 'button'
        noBtn.value = 'Non'
        noBtn.addEventListener('click', () => this.close())
        return noBtn
    }

    _buildForm() {
        const form = document.createElement('form')
        if (this.data?.form?.input) {
            form.append(this._buildHiddenInput())
        }
        form.append(this._buildCsrf())
        const noBtn = this._buildNoBtn()
        form.append(noBtn)
        const submit = document.createElement('input')
        submit.type = "submit"
        submit.value = this.data?.form?.submit
        form.append(submit)
        form.method = this.data?.form?.method
        if (isStartBySlash(this.data?.form?.action)) {
            form.action = this.data?.form?.action
        } else {
            form.action = this.data?.form?.action ? `${window.location.pathname}/${this.data?.form?.action}` : window.location.pathname
        }
        return form
    }

    _buildTitle() {
        const title = this.data?.title
        const h2 = document.createElement('h2')
        h2.append(title)
        return h2
    }

    _buildModal() {
        const form = this._buildForm()
        const h2 = this._buildTitle()
        const modal = document.createElement('div')
        const formModal = document.createElement('div')

        formModal.append(h2)
        formModal.append(form)
        formModal.classList.add('yes-no-modal')

        modal.append(formModal)
        modal.classList.add('modal')

        return modal
    }

    open() {
        const body = document.querySelector('body')
        this.modal = this._buildModal()
        body.append(this.modal)
    }

    close() {
        this.modal.remove()
    }
}

class MusicShortcodeModal {
    constructor(musics) {
        this.musics = musics
    }

    _generateShortCode() {
        const checkedCheckbox = $("#music-form-modal").find(":input:checked").toArray()
        let shortcode = '[!musiques'
        checkedCheckbox.forEach((checkbox, index) => {
            if (index === checkedCheckbox.length - 1) {
                shortcode += checkbox.value
            } else {
                shortcode += checkbox.value + ','
            }
        })
        shortcode += ']'
        $('#shortcode').val(shortcode)
    }

    _buildSubmit() {
        const submit = document.createElement('input')
        submit.type = "button"
        submit.value = "Générer"
        submit.addEventListener('click', () => this._generateShortCode())
        submit.classList.add('generate')
        return submit
    }

    _buildMusics() {
        return this.musics.map(music => {
            const musicRaw = document.createElement('div')
            musicRaw.classList.add('music-raw')

            const musicPicture = document.createElement('div')
            musicPicture.classList.add('music-picture')

            const musicDetails = document.createElement('div')
            musicDetails.classList.add('music-details')
            const title = document.createElement('p')
            title.append(`Titre : ${music.title}`)
            const category = document.createElement('p')
            category.append(`Catégorie : ${music.category}`)
            musicDetails.append(title)
            musicDetails.append(category)

            const musicCheckbox = document.createElement('div')
            musicCheckbox.classList.add('music-checkbox')
            const input = document.createElement('input')
            input.type = 'checkbox'
            input.value = music.id
            input.addEventListener('click', (event) => event.stopPropagation())
            musicCheckbox.append(input)

            musicRaw.append(musicPicture)
            musicRaw.append(musicDetails)
            musicRaw.append(musicCheckbox)
            musicRaw.addEventListener('click', () => input.checked = !input.checked)
            return musicRaw
        }).flat()
    }

    _buildForm() {
        const form = document.createElement('form')
        form.id = "music-form-modal"
        const musics = document.createElement('div')
        musics.classList.add('musics')
        this._buildMusics().forEach((music) => {
            musics.append(music)
        })
        form.append(musics)
        const shortcodeDiv = document.createElement('div')
        shortcodeDiv.classList.add('shortcode')

        const shortcode = document.createElement('input')
        shortcode.type = 'text'
        shortcode.id = "shortcode"
        shortcode.value = '[!musiques]'

        const copyButton = document.createElement('button')
        copyButton.append('Copier')
        copyButton.addEventListener('click', (event) => {
            event.preventDefault()
            this._copy()
        })
        copyButton.classList.add('button','button--primary')

        shortcodeDiv.append(shortcode)
        shortcodeDiv.append(copyButton)

        form.append(shortcodeDiv)
        form.append(this._buildSubmit())
        return form
    }

    _copy() {
        var copyText = document.getElementById("shortcode");

        /* Select the text field */
        copyText.select();
        copyText.setSelectionRange(0, 99999); /* For mobile devices */

        /* Copy the text inside the text field */
        document.execCommand("copy");
    }

    _buildTitle() {
        const title = 'Vos musiques'
        const h2 = document.createElement('h2')
        h2.append(title)
        return h2
    }

    _buildModal() {
        const form = this._buildForm()
        const h2 = this._buildTitle()

        const modal = document.createElement('div')
        const formModal = document.createElement('div')
        const nav = document.createElement('nav')
        const closeButton = document.createElement('button')
        const closeButtonBox = document.createElement('div')
        closeButtonBox.addEventListener('click', () => this.close())
        closeButtonBox.append(closeButton)
        nav.append(h2)
        nav.append(closeButtonBox)
        formModal.append(nav)
        formModal.append(form)
        formModal.classList.add('musics-modal')

        modal.append(formModal)
        modal.classList.add('modal')

        return modal
    }

    open() {
        const body = document.querySelector('body')
        this.modal = this._buildModal()
        body.append(this.modal)
    }

    close() {
        this.modal.remove()
    }
}

function isStartBySlash(str) {
    return str?.charAt(0) === '/'
}

$(document).ready(function () {
    /**
     * Select
     */
    $('.md-select').on('click', function () {
        $(this).toggleClass('active')
    })

    $('.md-select ul li').on('click', function () {
        const forAttr = $(this).attr('for')
        var v = $(this).text();
        $('.md-select ul li').not($(this)).removeClass('active');
        $(this).addClass('active');
        $('#' + forAttr).text(v)
    })

    $('.notification').click(function () {
        if ($('.notification-box').is(':hidden')) {
            $('.notification-box').show();
        } else {
            $('.notification-box').hide();
        }
    });

    /** View page.php */

    // LEFT SIDE BAR
    // hide all tabs
    $('#left-tabs').children().hide()
    $('#left-tabs').children().first().show()

    const leftTabs = [
        {
            id: 'music'
        },
    ]
    $(leftTabs.map(tab => '#' + tab.id).join(',')).on('click', function () {
        $('#left-tabs').children().hide()
        $(`[for=${$(this).attr('id')}]`).show()
    })

    // RIGHT SIDEBAR
    // hide all tabs
    $('#right-tabs').children().hide()
    $('#right-tabs').children().first().show()

    const rightTabs = [
        {
            id: 'settings'
        },
        {
            id: 'seo'
        }
    ]


    $(rightTabs.map(tab => '#' + tab.id).join(',')).on('click', function () {
        $('#right-tabs').children().hide()
        $(`[for=${$(this).attr('id')}]`).show()
    })

    $('.color-picker-wrapper').on('click', function () {
        const nextElement = $(this).next()
        nextElement.attr('type', 'color')
        setTimeout(() => {
            nextElement.click()
        }, 100)
        $(this).next().on('change', function () {
            $(this).attr("value", $(this).val())
            const name = $(this).attr('name')
            // set hexa value for elements with same attr for
            $(`[for=${name}]`).html($(this).val())
            // set background value for elements with same attr for
            $(`[for=${name}].color-picker`).css("background-color", $(this).val());
            // remove html value for color-picker
            $(`[for=${name}].color-picker`).html('')
            $(`[for=${name}].remove-color-picker`).html('Supprimer')
        })
    })

    $("input[type='color']").each(function () {
        // attribute to determine if there is a color set in bdd or not : 1 === yes 0 === no
        const attributeFor = Number($(this).attr('for'))
        const name = $(this).attr('name')
        if (!attributeFor) {
            $(this).attr("value", "")
            $(`[for=${name}]`).html('- - - - - -')
            // set background value for elements with same attr for
            // remove html value for color-picker
            $(`[for=${name}].color-picker`).html('')
            $(`[for=${name}].disabled-color-picker`).html('')
            $(`[for=${name}].remove-color-picker`).html('Supprimer')
            $(this).attr('type', 'hidden')
        } else {
            $(`[for=${name}]`).html($(this).val())
            $(`[for=${name}].color-picker`).css("background-color", $(this).val());
            $(`[for=${name}].color-picker`).html('')
            $(`[for=${name}].disabled-color-picker`).html('')
            $(`[for=${name}].remove-color-picker`).html('Supprimer')
        }
    })

    $("input[type='color']").on('change', function () {
        $(this).attr("value", $(this).val())
        const name = $(this).attr('name')
        // set hexa value for elements with same attr for
        $(`[for=${name}]`).html($(this).val())
        // set background value for elements with same attr for
        $(`[for=${name}].color-picker`).css("background-color", $(this).val());
        // remove html value for color-picker
        $(`[for=${name}].color-picker`).html('')
        $(`[for=${name}].remove-color-picker`).html('Supprimer')
    })

    $(".remove-color-picker").on('click', function (event) {
        event.stopPropagation()
        const idFor = $(this).attr('for')
        $(`input[name=${idFor}]`).attr('type', 'hidden')
        $(`#${idFor}`).attr('value', '')
        $(`[for=${idFor}]`).html('- - - - - -')
        // set background value for elements with same attr for
        $(`[for=${idFor}].color-picker`).css("background-color", $(this).val());
        // remove html value for color-picker
        $(`[for=${idFor}].color-picker`).html('')
        $(`[for=${idFor}].remove-color-picker`).html('Supprimer')
    })

    /** End view page.php */

})


/**
 * Helpers
 */

function addDays(date, days) {
    var result = new Date(date);
    result.setDate(result.getDate() + days);
    return result;
}