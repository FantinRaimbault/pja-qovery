<?php

use App\Core\Router\Router;
use App\Modules\BinksBeatHelper;
use App\Modules\Controllers\Templates\Models\Template;

?>

<div class="row full-height page-edition">
    <!-- LEFT SIDEBAR -->
    <div id="left-sidebar" class="row sidebar-edit-page">
        <div class="options">
            <div class="icon">
                <div id="music">
                    <p class="music"></p>
                </div>
            </div>
        </div>
        <div id="left-tabs" class="content-options">
            <ul for="music" class="text-align-center">
                <button onclick='showModalForAddMusics()' class="button button--secondary bb-margin-light-top">Ajouter mes musiques</button>
            </ul>
        </div>
    </div>
    <textarea id="tinymce" name="content"></textarea>
    <!-- RIGHT SIDEBAR -->
    <div id="right-sidebar" class="sidebar-edit-page flex flex-column">
        <div class="row bb-border-bottom">
            <div id="settings" class="tab flex-1 bb-border-right">
                <p class="settings margin-auto"></p>
            </div>
            <div id="seo" class="tab flex-1">
                <p class="seo margin-auto"></p>
            </div>
        </div>
        <div id="right-tabs" class="full-height flex flex-column">
            <div for="settings" class="flex flex-column flex-1">
                <div class="flex flex-column bb-margin-high-bottom">
                    <label>Couleur d'arrière plan :</label>
                    <div onclick='color_picker.click()' class="row color-picker-wrapper justify-content-space-between">
                        <div class="flex">
                            <div for="color_picker" class="color-picker bb-margin-medium-left bb-margin-medium-right"></div>
                            <p for="color_picker"></p>
                        </div>
                        <div class="flex">
                            <button class="remove-color-picker soft-button soft-button--orange bb-margin-light-right" for="color_picker"></button>
                        </div>
                    </div>
                    <input for="<?php echo $currentPage['backgroundColor'] ? 1 : 0 ?>" onchange="colorPickerOnChange()" id="color_picker" name="color_picker" type="color" value="<?php echo $currentPage['backgroundColor'] ?>">
                </div>
                <div class="flex flex-column bb-margin-high-bottom">
                    <label>Template Parent :</label>
                    <?php if (($_SESSION['currentProject']['templateApplied'])) : ?>
                        <button onclick='showModalForApplyTemplate()' class="button-light button--secondary bb-padding-10">Appliquer le Template parent</button>
                    <?php else : ?>
                        <a href="<?php Router::go('../../../templates') ?>"> <span class="underlined yellow">Vous ne possedez pas de Template Parent</span> </a>
                    <?php endif; ?>
                </div>
                <div class="flex flex-column bb-margin-high-bottom">
                    <label>Dernières modifications : 20/11/2020 à 17h33</label>
                </div>
            </div>
            <div for="seo" class="flex flex-column flex-1">
                <div class="flex flex-column bb-margin-high-bottom">
                    <label>Balise HTML Title (SEO)</label>
                    <input id="seo-title" oninput='onInputSeoTitle()' type="text" value="<?php echo $currentPage['seoTitle'] ?>" />
                </div>
                <div class="flex flex-column bb-margin-high-bottom">
                    <label>Balise Description HTML (SEO)</label>
                    <textarea id="seo-description" oninput='onInputSeoDescription()' class="height-200"><?= $currentPage['seoDescription'] ?></textarea>
                </div>
            </div>
        </div>
    </div>
</div>


<script src="https://cdn.tiny.cloud/1/s989d7t1555ikkqjx18527sclb7fhrjwhs3m7ionqylqz3us/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
<script type="text/javascript">
    const contentPage = <?php BinksBeatHelper::toJson($contentPage); ?>;
    const {
        backgroundColor,
        id: pageId
    } = <?php BinksBeatHelper::toJson($currentPage); ?>;
    const {
        id: projectId
    } = <?php BinksBeatHelper::toJson($currentProject); ?>;
    document.getElementById('content-status').style.color = '#2ED47A'
    document.getElementById('content-status').innerHTML = 'Sauvegarde effectuée'

    function addHeader() {
        setContentPage("<?php echo 123 ?>");
    }

    function colorPickerOnChange() {
        const backgroundColor = document.getElementById('color_picker').value
        savePage({
            backgroundColor
        }).then(() => {
            setBackgroundColorPage(backgroundColor)
        })
    }

    let savePageTimeOut;
    /**
     * @params page ex: { content : 'blablabla', backgroundColor: '#FFFFFF' }
     */
    function savePage(page) {
        return fetch('', {
                method: 'POST',
                body: JSON.stringify({
                    ...page,
                    csrf // this variable is in the parent script js (project_tpl.php)
                })
            })
            .then(res => res.json())
            .then(result => {
                document.getElementById('content-status').style.color = '#2ED47A'
                document.getElementById('content-status').innerHTML = 'Sauvegarde effectuée'
            })
            .catch(err => console.log(err))
    }

    function setContentPage(contentPage) {
        tinymce.get('tinymce').setContent(contentPage)
    }

    function setBackgroundColorPage(backgroundColor) {
        tinymce.get('tinymce').getBody().style.backgroundColor = backgroundColor
    }

    const plugins = [
        'preview',
        'paste',
        'autolink',
        // 'autosave',
        // 'save',
        'directionality',
        'code',
        'visualblocks',
        'visualchars',
        'fullscreen',
        'image',
        'link',
        'media',
        'template',
        'codesample',
        'table',
        'charmap',
        'hr',
        'pagebreak',
        'nonbreaking',
        'anchor',
        'toc',
        'insertdatetime',
        'advlist',
        'lists',
        'wordcount',
        'imagetools',
        'textpattern',
        'noneditable',
        'help',
        'charmap',
        // 'quickbars',
        'emoticons'
    ]

    const events = [
        'beforeinput',
        'blur',
        'click',
        'compositionend',
        'compositionstart',
        'compositionupdate',
        'contextmenu',
        'copy',
        'cut',
        'dbclick',
        'drag',
        'dragdrop',
        'dragend',
        'draggesture',
        'dragover',
        'dragstart',
        'drop',
        'focus',
        'focusin',
        'focusout',
        'input',
        'keydown',
        'keypress',
        'keyup',
        'mousedown',
        'mouseenter',
        'mouseleave',
        'mousemove',
        'mouseover',
        'mouseup',
        'paste',
        'reset',
        'submit',
        'touchcancel',
        'touchend',
        'touchmove',
        'touchstart',
        'wheel'
    ]

    tinymce.init({
        selector: 'textarea#tinymce',
        setup: (editor) => {
            editor.on('init', async function(event) {
                setContentPage(contentPage)
                setBackgroundColorPage(backgroundColor)
            });
        },
        init_instance_callback: function(editor) {
            editor.on('input ExecCommand ObjectResized SetContent', (e) => {
                document.getElementById('content-status').style.color = '#FFFFFF'
                document.getElementById('content-status').innerHTML = 'En cours ...'
                clearTimeout(savePageTimeOut)
                savePageTimeOut = setTimeout(function() {
                    savePage({
                        content: tinymce.get('tinymce').getContent()
                    })
                }, 1000);
            });
        },
        plugins: plugins.join(' '),
        imagetools_cors_hosts: ['picsum.photos'],
        menubar: 'file edit view insert format tools table help',
        toolbar: 'undo redo | bold italic underline strikethrough | fontselect fontsizeselect formatselect | alignleft aligncenter alignright alignjustify | outdent indent |  numlist bullist | forecolor backcolor removeformat | pagebreak | charmap emoticons | fullscreen  preview print | insertfile image media template link anchor codesample | ltr rtl',
        toolbar_sticky: true,
        autosave_ask_before_unload: true, // prevent popup
        autosave_interval: '30s',
        autosave_prefix: '{path}{query}-{id}-',
        autosave_restore_when_empty: false,
        autosave_retention: '2m',
        image_advtab: true,
        link_list: [{
                title: 'My page 1',
                value: 'https://www.tiny.cloud'
            },
            {
                title: 'My page 2',
                value: 'http://www.moxiecode.com'
            }
        ],
        image_list: [{
                title: 'My page 1',
                value: 'https://www.tiny.cloud'
            },
            {
                title: 'My page 2',
                value: 'http://www.moxiecode.com'
            }
        ],
        image_class_list: [{
                title: 'None',
                value: ''
            },
            {
                title: 'Some class',
                value: 'class-name'
            }
        ],
        importcss_append: true,
        file_picker_callback: function(callback, value, meta) {
            /* Provide file and text for the link dialog */
            if (meta.filetype === 'file') {
                callback('https://www.google.com/logos/google.jpg', {
                    text: 'My text'
                });
            }

            /* Provide image and alt text for the image dialog */
            if (meta.filetype === 'image') {
                callback('https://www.google.com/logos/google.jpg', {
                    alt: 'My alt text'
                });
            }

            /* Provide alternative source and posted for the media dialog */
            if (meta.filetype === 'media') {
                callback('movie.mp4', {
                    source2: 'alt.ogg',
                    poster: 'https://www.google.com/logos/google.jpg'
                });
            }
        },
        templates: [{
                title: 'New Table',
                description: 'creates a new table',
                content: '<div class="mceTmpl"><table width="98%%"  border="0" cellspacing="0" cellpadding="0"><tr><th scope="col"> </th><th scope="col"> </th></tr><tr><td> </td><td> </td></tr></table></div>'
            },
            {
                title: 'Starting my story',
                description: 'A cure for writers block',
                content: 'Once upon a time...'
            },
            {
                title: 'New list with dates',
                description: 'New List with dates',
                content: '<div class="mceTmpl"><span class="cdate">cdate</span><br /><span class="mdate">mdate</span><h2>My List</h2><ul><li></li><li></li></ul></div>'
            }
        ],
        template_cdate_format: '[Date Created (CDATE): %m/%d/%Y : %H:%M:%S]',
        template_mdate_format: '[Date Modified (MDATE): %m/%d/%Y : %H:%M:%S]',
        image_caption: true,
        quickbars_selection_toolbar: 'bold italic | quicklink h2 h3 blockquote quickimage quicktable',
        noneditable_noneditable_class: 'mceNonEditable',
        toolbar_mode: 'sliding',
        contextmenu: 'link image imagetools table',
        skin: 'oxide-dark',
        content_css: 'dark',
        content_style: 'body { font-family:serif; color: black }'
    })

    function onInputSeoTitle() {
        const {
            value
        } = document.getElementById('seo-title')
        document.getElementById('content-status').style.color = '#FFFFFF'
        document.getElementById('content-status').innerHTML = 'En cours ...'
        clearTimeout(savePageTimeOut)
        savePageTimeOut = setTimeout(function() {
            savePage({
                seoTitle: value
            })
        }, 1000);
    }

    function onInputSeoDescription() {
        const {
            value
        } = document.getElementById('seo-description')
        document.getElementById('content-status').style.color = '#FFFFFF'
        document.getElementById('content-status').innerHTML = 'En cours ...'
        clearTimeout(savePageTimeOut)
        savePageTimeOut = setTimeout(function() {
            savePage({
                seoDescription: value
            })
        }, 1000);
    }

    $(".remove-color-picker").on('click', function() {
        savePage({
            backgroundColor: ''
        }).then(() => {
            setBackgroundColorPage('')
        })
    })

    function showModalForApplyTemplate() {
        const modal = new YesNoModal({
            title: `Voulez vous appliquer le Template Parent sur cette page ?`,
            form: {
                method: 'POST',
                action: `/projects/${projectId}/templates/pages/${pageId}/apply`,
                csrf,
                submit: 'Oui'
            }
        })
        modal.open()
    }

    // need to add musics object in params of this function
    function showModalForAddMusics() {
        const modal = new MusicShortcodeModal([
            {
                id: 33,
                title: 'RR. 91',
                category: 'Rap',
            },
            {
                id: 23,
                title: 'Bande organisation',
                category: 'Rap',
            },
            {
                id: 19,
                title: 'Friday',
                category: 'Electro House',
            },
            {
                id: 30,
                title: 'Binks to binks partie 47',
                category: 'Rap',
            },
            {
                id: 99,
                title: 'Ich ich',
                category: 'Rap',
            },
        ])
        modal.open()
    }
</script>