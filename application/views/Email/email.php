<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid">
            <h3 class="mt-4">Broadcast Email</h3>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="<?= base_url() ?>">Dashboard</a></li>
                <li class="breadcrumb-item active"> Broadcast</li>
                <li class="breadcrumb-item active"> Buat</li>
            </ol>

            <div style="height: 100vh;">

                <form action="<?= base_url('email/kirim') ?>" method="POST">


                    <div class="form-group">
                        <label for="">Tujuan Kirim</label>
                        <select name="tujuan" class="form-control" id="tujuan_user" require>
                            <option value=""> -- Silakan Pilih -- </option>
                            <option value="0">Kirim Ke Per Orang</option>
                            <option value="1">Kirim Ke Per Pangkat</option>
                        </select>
                    </div>

                    <div class="form-group" id="alamat-personal">
                    </div>

                    <div class="form-group" id="alamat-pangkat">
                    </div>

                    <input type="" value=" " name="id_user" class="form-control" id="valPersonal">
                    <input type="" value=" " name="id_pangkat" class="form-control" id="valPangkat">


                    <div class="form-group">
                        <label for="">Subjek / Judul</label>
                        <input type="text" class="form-control" name="subjek" placeholder="Subjek">
                    </div>
                    <div class="form-group">
                        <label for="">Pesan Email</label>
                        <textarea cols="30" name="isi_surat" class="summernote" placeholder="Pesan Email" rows="10"></textarea>
                    </div>

                    <button class="btn btn-success" type="submit">Kirim Pesan</button>
                </form>

            </div>

        </div>
    </main>
</div>



<!-- Tagify -->
<script src="<?= base_url() ?>assets/tagify/dist/tagify.min.js"></script>
<script src="<?= base_url() ?>assets/tagify/dist/jQuery.tagify.min.js"></script>


<script>
    $("#tujuan_user").on('change', function() {
        // alert("hai")
        let input_ = '';
        if ($("#tujuan_user").val() == 0) {
            $("#alamat-pangkat").html('');
            let html = `
		    <label>Alamat Tujuan Berdasarkan Perorangan</label>
		    <input type="text" name="" id="personalNa" required>
    		`
            $("#alamat-personal").html(html);
            masukinTag('#personalNa', 'getUser')
        } else {
            $("#alamat-personal").html('');
            let html = `
		    <label>Alamat Tujuan Berdasarkan Pangkat</label>
		    <input type="text" name="" id="pangkatNa" required>
    		`
            $("#alamat-pangkat").html(html);
            masukinTag('#pangkatNa', 'getPangkat')
        }
        $("#valPangkat").val('')
        $("#valPersonal").val('')
    })

    function masukinTag(input, getNa) {
        (function() {
            var dataNa = [];
            var inputElm = document.querySelector(input);

            function tagTemplate(tagData) {
                return `
                <tag title="${tagData.email}"
                        contenteditable='false'
                        spellcheck='false'
                        tabIndex="-1"
                        class="tagify__tag ${tagData.class ? tagData.class : ""}"
                        ${this.getAttributes(tagData)}>
                    <x title='' class='tagify__tag__removeBtn' role='button' aria-label='remove tag'></x>
                    <div>
                        <div class='tagify__tag__avatar-wrap'>
                            <img src="${url}/assets/images/icon.png">
                        </div>
                        <span class='tagify__tag-text'>${tagData.name}</span>
                    </div>
                </tag>
            `
            }

            function suggestionItemTemplate(tagData) {
                return `
                <div ${this.getAttributes(tagData)}
                    class='tagify__dropdown__item ${tagData.class ? tagData.class : ""}'
                    tabindex="0"
                    role="option">
                    ${ url + `/assets/images/icon.png` ? `
                    <div class='tagify__dropdown__item__avatar-wrap'>
                        <img src="${url}/assets/images/icon.png">
                    </div>` : ''
				}
                    <strong>${tagData.name}</strong>
                    
                </div>
            `
            }

            $.ajax({
                dataType: "json",
                url: url + `email/${getNa}`,
                type: 'GET',
                success: function(result) {
                    result.forEach(element => {
                        dataNa.push({
                            'value': element.value,
                            'name': element.name
                        })
                    });
                }
            })

            // initialize Tagify on the above input node reference
            var tagify = new Tagify(inputElm, {
                enforceWhitelist: true,
                skipInvalid: true, // do not remporarily add invalid tags
                dropdown: {
                    closeOnSelect: false,
                    enabled: 0,
                    classname: 'users-list',
                    searchKeys: ['name'] // very important to set by which keys to search for suggesttions when typing
                },
                templates: {
                    tag: tagTemplate,
                    dropdownItem: suggestionItemTemplate
                },
                whitelist: dataNa
            })



            tagify.on('dropdown:show dropdown:updated', onDropdownShow)
            tagify.on('dropdown:select', onSelectSuggestion)

            var addAllSuggestionsElm;

            function onDropdownShow(e) {
                var dropdownContentElm = e.detail.tagify.DOM.dropdown.content;

                if (tagify.suggestedListItems.length > 1) {
                    addAllSuggestionsElm = getAddAllSuggestionsElm();

                    // insert "addAllSuggestionsElm" as the first element in the suggestions list
                    dropdownContentElm.insertBefore(addAllSuggestionsElm, dropdownContentElm.firstChild)
                }
            }

            function onSelectSuggestion(e) {
                if (e.detail.elm == addAllSuggestionsElm)
                    tagify.dropdown.selectAll.call(tagify);
            }

            // create a "add all" custom suggestion element every time the dropdown changes
            function getAddAllSuggestionsElm() {
                // suggestions items should be based on "dropdownItem" template
                return tagify.parseTemplate('dropdownItem', [{
                    class: "addAll",
                    name: "Add all",
                    email: tagify.settings.whitelist.reduce(function(remainingSuggestions, item) {
                        return tagify.isTagDuplicate(item.value) ? remainingSuggestions : remainingSuggestions + 1
                    }, 0) + " Members"
                }])
            }
        })()
    }



    $(document).delegate('#personalNa', 'change', function() {
        // alert("Asdasdasd")
        let dataNa = JSON.parse($('#personalNa').val());
        let idNa = ''
        dataNa.forEach(element => {
            idNa += `${element.value},`
        });
        $("#valPersonal").val(idNa)
    })

    $(document).delegate('#pangkatNa', 'change', function() {
        // alert("Asdasdasd")
        let dataNa = JSON.parse($("#pangkatNa").val());
        let idNa = ''
        dataNa.forEach(element => {
            idNa += `${element.value},`
        });
        $("#valPangkat").val(idNa)
    })
</script>