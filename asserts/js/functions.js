function editBasicInfo() {

    //trimitem request catre /api/cv/edit/id
    axios({
        url: `/api/cv/edit/${getCVIdFromURL()}`, 
        method: 'put',
        baseUrl: `${localStorage.getItem('base_url')}`, //getItem functie din localstorage
        headers: {
            'Authorization': `Bearer ${localStorage.getItem('key')}`
        },
        data: {
            name: $('#nameInput').val(),
            phone: $('#phoneInput').val(),
            adress: $('#adressInput').val(),
            contry: $('#countryInput').val(),
            email_contact: $('#emailInput').val()
        }
    }).then((response) => {
        showPopupError(response.data.message);

    }).catch((error) => {
        //intrare in raspuns de eroare

        //apelare functia showPopupError
        showPopupError(error.response.data.message);
    });
}

function saveObjective() {
    //facem request la /api/cv/get/{id}
    axios({
        url: `/api/objective/get/${getCVIdFromURL()}`,
        method: 'get',
        baseUrl: `${localStorage.getItem('base_url')}`,
        headers: {
            'Authorization': `Bearer ${localStorage.getItem('key')}`
        }
    }).then((response) => {

        const position = $('#position').val();
        const time = $('#time').val();
        const company = $('#company').val();
        const domain = $('#domain').val();

        if (response.data != null) {

            const id = response.data.pk_id;

            //facem request la /api/cv/get/{id}
            axios({
                url: `/api/objective/edit/${getCVIdFromURL()}/${id}`,
                method: 'put',
                baseUrl: `${localStorage.getItem('base_url')}`,
                headers: {
                    'Authorization': `Bearer ${localStorage.getItem('key')}`
                },
                data: {
                    position,
                    time,
                    company,
                    domain
                }
            }).then((response) => {

                showPopupError(response.data.message);

            }).catch((error) => {
                //intrare in raspuns de eroare

                //apelare functia showPopupError
                showPopupError(error.response.data.message);
            });
        } else {
            //facem request la /api/cv/get/{id}
            axios({
                url: `/api/objective/create/${getCVIdFromURL()}`,
                method: 'post',
                baseUrl: `${localStorage.getItem('base_url')}`,
                headers: {
                    'Authorization': `Bearer ${localStorage.getItem('key')}`
                },
                data: {
                    position,
                    time,
                    company,
                    domain
                }
            }).then((response) => {

                showPopupError("Created succesfully");

            }).catch((error) => {
                //intrare in raspuns de eroare

                //apelare functia showPopupError
                showPopupError(error.response.data.message);
            });
        }

    }).catch((error) => {
        //intrare in raspuns de eroare

        //apelare functia showPopupError
        showPopupError(error.response.data.message);
    });
}

function generateRandomId(length) {
    var result = '';
    var characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    var charactersLength = characters.length;
    for (var i = 0; i < length; i++) {
        result += characters.charAt(Math.floor(Math.random() * charactersLength));
    }
    return result;
}

function addEducation() {
    const randomId = generateRandomId(10);

    //generam html-ul, cu data-editable = false, prin acest lucru stim ca este un obiect nou care nu exista in baza de date
    const html = `    <div class="container margin-top-100 educationItems" id="${randomId}" data-editable="false">
            <div class="row align-items-center">
                <div class="col-12 mx-auto">
                    <div class="jumbotron center-section-container shadow p-3">
    
                        <h2>Education</h2>
    
                        <div class="row">
                            <div class="form-group col-md-6">
                                <input type="text" placeholder="School Name" class="form-control custom-input"
                                    id="school_name" aria-describedby="emailHelp">
                            </div>
                            <div class="form-group col-md-6">
                                <input type="text" placeholder="Address" class="form-control custom-input"
                                    id="adress" aria-describedby="emailHelp">
                            </div>
                            <div class="form-group col-md-6">
                                <input type="text" placeholder="Start Year" class="form-control custom-input"
                                    id="start_year" aria-describedby="emailHelp">
                            </div>
                            <div class="form-group col-md-6">
                                <input type="text" placeholder="End Year" class="form-control custom-input"
                                    id="end_year" aria-describedby="emailHelp">
                            </div>
                            <div class="form-group col-md-6">
                                <input type="text" placeholder="Section" class="form-control custom-input"
                                    id="section" aria-describedby="emailHelp">
                            </div>
                        </div>
    
                        <button onclick="addEducation()" class="btn btn-primary">Add</button>
                        <button onclick="removeEducation(undefined, '${randomId}')"class="btn btn-primary removeButton">Remove</button>
    
                    </div>
                </div>
            </div>
        </div>`;

    $('#containerEducation').append(html);
}

function addExperience() {
    const randomId = generateRandomId(10);

    //generam html-ul, cu data-editable = false, prin acest lucru stim ca este un obiect nou care nu exista in baza de date
    const html = `    <div class="container margin-top-100 experienceItems" id="${randomId}" data-editable="false">
            <div class="row align-items-center">
                <div class="col-12 mx-auto">
                    <div class="jumbotron center-section-container shadow p-3">
    
                        <h2>Education</h2>
    
                        <div class="row">
                            <div class="form-group col-md-6">
                                <input type="text" placeholder="Company Name" class="form-control custom-input"
                                    id="company_name" aria-describedby="emailHelp">
                            </div>
                            <div class="form-group col-md-6">
                                <input type="text" placeholder="Address" class="form-control custom-input"
                                    id="adress" aria-describedby="emailHelp">
                            </div>
                            <div class="form-group col-md-6">
                                <input type="text" placeholder="Start Year" class="form-control custom-input"
                                    id="start_year" aria-describedby="emailHelp">
                            </div>
                            <div class="form-group col-md-6">
                                <input type="text" placeholder="End Year" class="form-control custom-input"
                                    id="end_year" aria-describedby="emailHelp">
                            </div>
                            <div class="form-group col-md-6">
                                <input type="text" placeholder="Position" class="form-control custom-input"
                                    id="position" aria-describedby="emailHelp">
                            </div>
                        </div>
    
                        <button onclick="addExperience()" class="btn btn-primary">Add</button>
                        <button onclick="removeExperience(undefined, '${randomId}')"class="btn btn-primary removeButton">Remove</button>
    
                    </div>
                </div>
            </div>
        </div>`;

    $('#containerExperience').append(html);
}

function addInterests() {
    const randomId = generateRandomId(10);

    let html = `<div class="row interestItems" id="${randomId}" data-editable="false">
        <div class="form-group col-md-4">
            <input type="text" placeholder="Interest" class="form-control custom-input"
                id="interest_name" aria-describedby="emailHelp">
        </div>
        <div class="form-group col-md-6">
            <input type="text" placeholder="Description" class="form-control custom-input"
                id="description" aria-describedby="emailHelp">
        </div>
        <div class="col-md-2">
            <button onclick="removeInterests(undefined, '${randomId}')" class="btn btn-primary removeButtonLine">Remove</button>
        </div>
    </div>`;

    $('#interestsContainer').append(html);
}

function addTechnicalSkill() {
    const randomId = generateRandomId(10);

    const html = `<div class="row technicalItems" id="${randomId}" data-type="TEHNIC" data-editable="false">
        <div class="form-group col-md-4">
            <input type="text" placeholder="Skill Name" class="form-control custom-input"
                id="skill_name" aria-describedby="emailHelp">
        </div>
        <div class="form-group col-md-6">
            <input type="text" placeholder="Description" class="form-control custom-input"
                id="description" aria-describedby="emailHelp">
        </div>
        <div class="col-md-2">
            <button onclick="removeSkills(undefined, '${randomId}', 'technicalItems')" class="btn btn-primary removeButtonLine">Remove</button>
        </div>
    </div>`;

    $('#TechnicalContainer').append(html);
}

function addPersonalSkill() {
    const randomId = generateRandomId(10);

    const html = `<div class="row personalItems" id="${randomId}" data-type="PERSONAL" data-editable="false">
        <div class="form-group col-md-4">
            <input type="text" placeholder="Skill Name" class="form-control custom-input"
                id="skill_name" aria-describedby="emailHelp">
        </div>
        <div class="form-group col-md-6">
            <input type="text" placeholder="Description" class="form-control custom-input"
                id="description" aria-describedby="emailHelp">
        </div>
        <div class="col-md-2">
            <button onclick="removeSkills(undefined, '${randomId}', 'personalItems')" class="btn btn-primary removeButtonLine">Remove</button>
        </div>
    </div>`;

    $('#PersonalContainer').append(html);
}

function removeInterests(id, randomId) {
    if (id == undefined) {
        $(`#${randomId}`).remove();

        if ($('.interestItems').length == 0) {
            addInterests();
        }

        return;
    }

    //daca este un id valid, il stergem din baza de date si apoi din html
    axios({
        url: `/api/interests/delete/${getCVIdFromURL()}/${id}`,
        method: 'delete',
        baseUrl: `${localStorage.getItem('base_url')}`,
        headers: {
            'Authorization': `Bearer ${localStorage.getItem('key')}`
        }
    }).then((response) => {

        showPopupError(response.data.message);

        //cv creat cu success, retrimitem la view-ul pt edit
        $(`#${randomId}`).remove();

        //verificam daca s-au sters toate datele, daca s-au sters atunci trebuie sa dam un imput de inceput
        //facem request la /api/cv/get/{id}
        axios({
            url: `/api/interests/getAll/${getCVIdFromURL()}`,
            method: 'get',
            baseUrl: `${localStorage.getItem('base_url')}`,
            headers: {
                'Authorization': `Bearer ${localStorage.getItem('key')}`
            }
        }).then((response) => {

            if (response.data.length == 0) {
                addInterests();
            }

        }).catch((error) => {
            //intrare in raspuns de eroare

            //apelare functia showPopupError
            showPopupError(error.response.data.message);
        });

    }).catch((error) => {
        //intrare in raspuns de eroare

        //apelare functia showPopupError
        showPopupError(error.response.data.message);
    });
}

function removeSkills(id, randomId, type) {
    if (id == undefined) {
        $(`#${randomId}`).remove();

        if ($(`.${type}`).length == 0) {
            if (type == 'personalItems') {
                addPersonalSkill();
            }
            if (type == 'technicalItems') {
                addTechnicalSkill();
            }
        }

        return;
    }

    //daca este un id valid, il stergem din baza de date si apoi din html
    axios({
        url: `/api/skills/delete/${getCVIdFromURL()}/${id}`,
        method: 'delete',
        baseUrl: `${localStorage.getItem('base_url')}`,
        headers: {
            'Authorization': `Bearer ${localStorage.getItem('key')}`
        }
    }).then((response) => {

        showPopupError(response.data.message);

        //cv creat cu success, retrimitem la view-ul pt edit
        $(`#${randomId}`).remove();

        //verificam daca s-au sters toate datele, daca s-au sters atunci trebuie sa dam un imput de inceput
        //facem request la /api/cv/get/{id}
        axios({
            url: `/api/skills/get/${getCVIdFromURL()}`,
            method: 'get',
            baseUrl: `${localStorage.getItem('base_url')}`,
            headers: {
                'Authorization': `Bearer ${localStorage.getItem('key')}`
            }
        }).then((response) => {

            let existsTehnic = false,
                existsPersonal = false;

            response.data.forEach(element => {
                const randomId = generateRandomId(10);

                if (element.skill_type == "TEHNIC") {
                    existsTehnic = true;
                }
                if (element.skill_type == "PERSONAL") {
                    existsPersonal = true;
                }
            });

            if (existsTehnic == false && $('.technicalItems').length == 0) {
                addTechnicalSkill();
            }

            if (existsPersonal == false && $('.personalItems').length == 0) {
                addPersonalSkill();
            }

        }).catch((error) => {
            //intrare in raspuns de eroare

            //apelare functia showPopupError
            showPopupError(error.response.data.message);
        });

    }).catch((error) => {
        //intrare in raspuns de eroare

        //apelare functia showPopupError
        showPopupError(error.response.data.message);
    });
}

function removeEducation(id, randomId) {

    //daca id-ul este undefined, nu se afla in baza de date
    //deci putem sa il stergem doar din html
    if (id === undefined) { //daca este nul, deci nu apare in baza de date, il stergem

        $(`#${randomId}`).remove(); 

        if ($('.educationItems').length == 0) {
            addEducation();
        }

        return;
    }

    //daca este un id valid, il stergem din baza de date si apoi din html
    axios({
        url: `/api/education/delete/${getCVIdFromURL()}/${id}`,
        method: 'delete',
        baseUrl: `${localStorage.getItem('base_url')}`,
        headers: {
            'Authorization': `Bearer ${localStorage.getItem('key')}`
        }
    }).then((response) => {

        showPopupError(response.data.message);

        //cv creat cu success, retrimitem la view-ul pt edit
        $(`#${randomId}`).remove();

        //verificam daca s-au sters toate datele, daca s-au sters atunci trebuie sa dam un imput de inceput
        //facem request la /api/cv/get/{id}
        axios({
            url: `/api/education/get/${getCVIdFromURL()}`,
            method: 'get',
            baseUrl: `${localStorage.getItem('base_url')}`,
            headers: {
                'Authorization': `Bearer ${localStorage.getItem('key')}`
            }
        }).then((response) => {

            if (response.data.length == 0) {
                addEducation();
            }

        }).catch((error) => {
            //intrare in raspuns de eroare

            //apelare functia showPopupError
            showPopupError(error.response.data.message);
        });

    }).catch((error) => {
        //intrare in raspuns de eroare

        //apelare functia showPopupError
        showPopupError(error.response.data.message);
    });
}

function removeExperience(id, randomId) {

    //daca id-ul este undefined, nu se afla in baza de date
    //deci putem sa il stergem doar din html
    if (id === undefined) {

        $(`#${randomId}`).remove();

        if ($('.experienceItems').length == 0) {
            addExperience();
        }

        return;
    }

    //daca este un id valid, il stergem din baza de date si apoi din html
    axios({
        url: `/api/experience/delete/${getCVIdFromURL()}/${id}`,
        method: 'delete',
        baseUrl: `${localStorage.getItem('base_url')}`,
        headers: {
            'Authorization': `Bearer ${localStorage.getItem('key')}`
        }
    }).then((response) => {

        showPopupError(response.data.message);

        //cv creat cu success, retrimitem la view-ul pt edit
        $(`#${randomId}`).remove();

        //verificam daca s-au sters toate datele, daca s-au sters atunci trebuie sa dam un imput de inceput
        //facem request la /api/cv/get/{id}
        axios({
            url: `/api/experience/get/${getCVIdFromURL()}`,
            method: 'get',
            baseUrl: `${localStorage.getItem('base_url')}`,
            headers: {
                'Authorization': `Bearer ${localStorage.getItem('key')}`
            }
        }).then((response) => {

            if (response.data.length == 0) {
                addExperience();
            }

        }).catch((error) => {
            //intrare in raspuns de eroare

            //apelare functia showPopupError
            showPopupError(error.response.data.message);
        });

    }).catch((error) => {
        //intrare in raspuns de eroare

        //apelare functia showPopupError
        showPopupError(error.response.data.message);
    });
}

function editAboutYouInfo() {
    let arrOfElements = $('.interestItems');

    arrOfElements.each(function (index, item) {
        const id_element = $(item).attr('id');
        const interest_name = $(`#${id_element} #interest_name`).val();
        const description = $(`#${id_element} #description`).val();

        if ($(item).data('editable')) {
            const id = $(item).data('id');

            axios({
                url: `/api/interests/edit/${getCVIdFromURL()}/${id}`,
                method: 'put',
                baseUrl: `${localStorage.getItem('base_url')}`,
                headers: {
                    'Authorization': `Bearer ${localStorage.getItem('key')}`
                },
                data: {
                    interest_name,
                    description
                }
            }).then((response) => {

            }).catch((error) => {
                //intrare in raspuns de eroare

                //apelare functia showPopupError
                showPopupError(error.response.data.message);
            });
        } else {
            axios({
                url: `/api/interests/create/${getCVIdFromURL()}`,
                method: 'post',
                baseUrl: `${localStorage.getItem('base_url')}`,
                headers: {
                    'Authorization': `Bearer ${localStorage.getItem('key')}`
                },
                data: {
                    interest_name,
                    description
                }
            }).then((response) => {

            }).catch((error) => {
                //intrare in raspuns de eroare

                //apelare functia showPopupError
                showPopupError(error.response.data.message);
            });
        }
    })

    //facem request la /api/cv/get/{id}
    axios({
        url: `/api/statement/get/${getCVIdFromURL()}`,
        method: 'get',
        baseUrl: `${localStorage.getItem('base_url')}`,
        headers: {
            'Authorization': `Bearer ${localStorage.getItem('key')}`
        }
    }).then((response) => {
        if (response.data.length == 0) {
            axios({
                url: `/api/statement/create/${getCVIdFromURL()}`,
                method: 'post',
                baseUrl: `${localStorage.getItem('base_url')}`,
                headers: {
                    'Authorization': `Bearer ${localStorage.getItem('key')}`
                },
                data: {
                    statement_text: $('#statement').val()
                }
            }).then((response) => {

            }).catch((error) => {
                //intrare in raspuns de eroare

                //apelare functia showPopupError
                showPopupError(error.response.data.message);
            });
        } else {
            axios({
                url: `/api/statement/edit/${getCVIdFromURL()}/${response.data[0].pk_id}`,
                method: 'put',
                baseUrl: `${localStorage.getItem('base_url')}`,
                headers: {
                    'Authorization': `Bearer ${localStorage.getItem('key')}`
                },
                data: {
                    statement_text: $('#statement').val()
                }
            }).then((response) => {

            }).catch((error) => {
                //intrare in raspuns de eroare

                //apelare functia showPopupError
                showPopupError(error.response.data.message);
            });
        }

        console.log(response);

    }).catch((error) => {
        //intrare in raspuns de eroare

        //apelare functia showPopupError
        showPopupError(error.response.data.message);
    });
}

function saveSkills(){
    let arrOfElements = $('.technicalItems');

    arrOfElements.each(function (index, item) {
        const id_element = $(item).attr('id');
        const skill_name = $(`#${id_element} #skill_name`).val();
        const description = $(`#${id_element} #description`).val();
        const skill_type = $(item).data('type');

        if ($(item).data('editable')) {
            const id = $(item).data('id');

            axios({
                url: `/api/skills/edit/${getCVIdFromURL()}/${id}`,
                method: 'put',
                baseUrl: `${localStorage.getItem('base_url')}`,
                headers: {
                    'Authorization': `Bearer ${localStorage.getItem('key')}`
                },
                data: {
                    skill_name,
                    description,
                    skill_type
                }
            }).then((response) => {

            }).catch((error) => {
                //intrare in raspuns de eroare

                //apelare functia showPopupError
                showPopupError(error.response.data.message);
            });
        } else {
            axios({
                url: `/api/skills/create/${getCVIdFromURL()}`,
                method: 'post',
                baseUrl: `${localStorage.getItem('base_url')}`,
                headers: {
                    'Authorization': `Bearer ${localStorage.getItem('key')}`
                },
                data: {
                    skill_name,
                    description,
                    skill_type
                }
            }).then((response) => {

            }).catch((error) => {
                //intrare in raspuns de eroare

                //apelare functia showPopupError
                showPopupError(error.response.data.message);
            });
        }
    });

    arrOfElements = $('.personalItems');

    arrOfElements.each(function (index, item) {
        const id_element = $(item).attr('id');
        const skill_name = $(`#${id_element} #skill_name`).val();
        const description = $(`#${id_element} #description`).val();
        const skill_type = $(item).data('type');

        if ($(item).data('editable')) {
            const id = $(item).data('id');

            axios({
                url: `/api/skills/edit/${getCVIdFromURL()}/${id}`,
                method: 'put',
                baseUrl: `${localStorage.getItem('base_url')}`,
                headers: {
                    'Authorization': `Bearer ${localStorage.getItem('key')}`
                },
                data: {
                    skill_name,
                    description,
                    skill_type
                }
            }).then((response) => {

            }).catch((error) => {
                //intrare in raspuns de eroare

                //apelare functia showPopupError
                showPopupError(error.response.data.message);
            });
        } else {
            axios({
                url: `/api/skills/create/${getCVIdFromURL()}`,
                method: 'post',
                baseUrl: `${localStorage.getItem('base_url')}`,
                headers: {
                    'Authorization': `Bearer ${localStorage.getItem('key')}`
                },
                data: {
                    skill_name,
                    description,
                    skill_type
                }
            }).then((response) => {

            }).catch((error) => {
                //intrare in raspuns de eroare

                //apelare functia showPopupError
                showPopupError(error.response.data.message);
            });
        }
    })
}

function saveEducation() {
    //preiau toate elementele de tip education si verific daca au tagul data-editable
    let arrOfElements = $('.educationItems');

    arrOfElements.each(function (index, item) {

        const id_element = $(item).attr('id');
        const school_name = $(`#${id_element} #school_name`).val();
        const adress = $(`#${id_element} #adress`).val();
        const start_year = $(`#${id_element} #start_year`).val();
        const end_year = $(`#${id_element} #end_year`).val();
        const section = $(`#${id_element} #section`).val();

        //daca elementul este editabil ( adica este creat deja in baza de date ) apelez editarea, daca nu, creez il baza de date
        if ($(item).data('editable')) {
            const id = $(item).data('id');

            axios({
                url: `/api/education/edit/${getCVIdFromURL()}/${id}`,
                method: 'put',
                baseUrl: `${localStorage.getItem('base_url')}`,
                headers: {
                    'Authorization': `Bearer ${localStorage.getItem('key')}`
                },
                data: {
                    school_name,
                    adress,
                    start_year,
                    end_year,
                    section
                }
            }).then((response) => {

            }).catch((error) => {
                //intrare in raspuns de eroare

                //apelare functia showPopupError
                showPopupError(error.response.data.message);
            });
        } else {
            axios({
                url: `/api/education/create/${getCVIdFromURL()}`,
                method: 'post',
                baseUrl: `${localStorage.getItem('base_url')}`,
                headers: {
                    'Authorization': `Bearer ${localStorage.getItem('key')}`
                },
                data: {
                    school_name,
                    adress,
                    start_year,
                    end_year,
                    section
                }
            }).then((response) => {

            }).catch((error) => {
                //intrare in raspuns de eroare

                //apelare functia showPopupError
                showPopupError(error.response.data.message);
            });
        }
    });
}

axios({
    url: `url`,
    method: 'http_type',
    baseUrl: `base_url`,
    data: {

    }
}).then((response) => {

    console.log(response);

}).catch((error) => {

    console.log(error);
    
});

function logoutFunction() {
    localStorage.clear();
    location.reload();
}

function saveExperience() {
    //preiau toate elementele de tip education si verific daca au tagul data-editable
    let arrOfElements = $('.experienceItems');

    arrOfElements.each(function (index, item) {

        const id_element = $(item).attr('id');
        const company_name = $(`#${id_element} #company_name`).val();
        const adress = $(`#${id_element} #adress`).val();
        const start_year = $(`#${id_element} #start_year`).val();
        const end_year = $(`#${id_element} #end_year`).val();
        const position = $(`#${id_element} #position`).val();

        //daca elementul este editabil ( adica este creat deja in baza de date ) apelez editarea, daca nu, creez il baza de date
        if ($(item).data('editable')) {
            const id = $(item).data('id');

            axios({
                url: `/api/experience/edit/${getCVIdFromURL()}/${id}`,
                method: 'put',
                baseUrl: `${localStorage.getItem('base_url')}`,
                headers: {
                    'Authorization': `Bearer ${localStorage.getItem('key')}`
                },
                data: {
                    company_name,
                    adress,
                    start_year,
                    end_year,
                    position
                }
            }).then((response) => {

            }).catch((error) => {
                //intrare in raspuns de eroare

                //apelare functia showPopupError
                showPopupError(error.response.data.message);
            });
        } else {
            axios({
                url: `/api/experience/create/${getCVIdFromURL()}`,
                method: 'post',
                baseUrl: `${localStorage.getItem('base_url')}`,
                headers: {
                    'Authorization': `Bearer ${localStorage.getItem('key')}`
                },
                data: {
                    company_name,
                    adress,
                    start_year,
                    end_year,
                    position
                }
            }).then((response) => {

            }).catch((error) => {
                //intrare in raspuns de eroare

                //apelare functia showPopupError
                showPopupError(error.response.data.message);
            });
        }
    });
}

function getCVIdFromURL() {
    const arr = window.location.href.split('/');
    return arr[arr.length - 1];
}


function createCV() {
    //facem request la /api/cv/getall
    axios({
        url: `/api/cv/create`,
        method: 'post',
        baseUrl: `${localStorage.getItem('base_url')}`,
        headers: {
            'Authorization': `Bearer ${localStorage.getItem('key')}`
        },
        data: {
            cv_name: $('#cv_name').val()
        }
    }).then((response) => {

        console.log(response.data);

        //cv creat cu success, retrimitem la view-ul pt edit
        setTimeout(() => {
            window.location.href = `${localStorage.getItem('base_url')}/builder/view/${response.data.id}`;
        }, 1000);

    }).catch((error) => {
        //intrare in raspuns de eroare

        //apelare functia showPopupError
        showPopupError(error.response.data.message);
    });
}

function registerAction() {
    //preiau valorile din inputuri prin id-ul elementelui
    const username = $('#usernameInput').val();
    const email = $('#emailInput').val();
    const password = $('#passwordInput').val();
    const confirmPassword = $('#confirmPasswordInput').val();

    //request post catre API
    axios({
        url: `/api/account/register`,
        method: 'post',
        baseUrl: `${localStorage.getItem('base_url')}`,
        data: {
            username: username,
            email: email,
            password: password,
            confirmPassword: confirmPassword
        }
    }).then((response) => {
        //intrare in raspuns cu status success

        //apelare functia showPopupError
        showPopupError(response.data.message);

        //setare ca dupa 3 secunde sa te retrimita la login
        setTimeout(() => {
            window.location.href = `${localStorage.getItem('base_url')}/account/login`;
        }, 3000);

    }).catch((error) => {
        //intrare in raspuns de eroare

        //apelare functia showPopupError
        showPopupError(error.response.data.message);
    });

}

function loginAction() {
    //preiau valorile din inputuri prin id-ul elementelui
    const email = $('#emailInput').val();
    const password = $('#passwordInput').val();

    //request post catre API
    axios({
        url: `/api/account/login`,
        method: 'post',
        baseUrl: `${localStorage.getItem('base_url')}`,
        data: {
            email: email,
            password: password,
        }
    }).then((response) => {
        //intrare in raspuns cu status success

        //apelare functia showPopupError
        showPopupError(response.data.message);

        //setare in localstorage key-ul si cand expira
        localStorage.setItem("key", response.data.key);
        localStorage.setItem("expire", response.data.expiry);
        localStorage.setItem('auth_date', new Date().getTime());

        //setare ca dupa 3 secunde sa te retrimita la login
        setTimeout(() => {
            window.location.href = `${localStorage.getItem('base_url')}`;
        }, 1000);

    }).catch((error) => {
        //intrare in raspuns de eroare

        //apelare functia showPopupError
        showPopupError(error.response.data.message);
    });
}

function showPopupError(message) {
    //afisare popup de raspuns
    $('#error_popup').show();
    //setare mesaj in status de raspuns
    $('#error_content').text(message);

    //setare ca statusul sa dispara dupa 3 secunde
    setTimeout(() => {
        $('#error_popup').hide();
    }, 3000);
}