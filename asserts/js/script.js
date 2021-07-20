const readyFunctionByPageName = [];
readyFunctionByPageName['index'] = function () {
    //preluam key-ul din localstorage sa verificam daca este logat in aplicatie
    const key_storage = localStorage.getItem("key");

    //verificam daca key_storage este diferit de null
    if (key_storage != null) {
        //setam butoanele pentru userul logat si linkurile la butoane
        $('#register_button').text('Logout');
        $('#register_button').attr('onclick', `logoutFunction()`);//seteaza pt atributul onclick ce ii setez eu (functia attr())
        $('#login_button').text('Go to builder');
        $('#login_button').attr('href', `${localStorage.getItem('base_url')}/builder/list`);
    } else {
        //setam butoanele pentru userul nelogat
        $('#register_button').text('Login');
        $('#register_button').attr('href', `${localStorage.getItem('base_url')}/account/login`);
        $('#login_button').text('Register');
        $('#login_button').attr('href', `${localStorage.getItem('base_url')}/account/register`);
    }
};

readyFunctionByPageName['builder/list'] = function () {

    //facem request la /api/cv/getall
    axios({
        url: `/api/cv/getall`,
        method: 'get',
        baseUrl: `${localStorage.getItem('base_url')}`,
        headers: {
            'Authorization': `Bearer ${localStorage.getItem('key')}`
        } //trimit catre server la fiecare request acel key pt a stii ca user ul este logat
    }).then((response) => {

        //preluam raspunsul si generam html-ul pt fiecare cv gasit in baza de date
        response.data.forEach(element => {
            const html = `<div class="container">
                <div class="row align-items-center">
                    <div class="col-12 mx-auto">
                        <div class="jumbotron center-section-container shadow p-3">
                            <h2 style="margin-bottom: 0;">${element.display_name}</h2>
                            <a href="${localStorage.getItem('base_url')}/builder/view/${element.pk_id}" class="btn btn-primary viewButton">View</a>
                        </div>
                    </div>
                </div>
            </div>`;

            //adaugam html-ul in cotnainerul CvListContainer
            $('#CvListContainer').append(html);
        });
    }).catch((error) => {
        //intrare in raspuns de eroare

        //apelare functia showPopupError
        showPopupError(error.response.data.message);
    });

    console.log("cevasfasdagsd");
};

readyFunctionByPageName['builder/view'] = function () {

    //facem request la /api/cv/get/{id}
    axios({
        url: `/api/cv/get/${getCVIdFromURL()}`,
        method: 'get',
        baseUrl: `${localStorage.getItem('base_url')}`,
        headers: {
            'Authorization': `Bearer ${localStorage.getItem('key')}`
        }
    }).then((response) => {

        //verific daca name-ul cv-ului este setat in baza de date
        if (response.data.name != "") {
            //este afisat, deci generam html-ul si il afisam pe pagina
            const html = `<h3>Name</h3>
                <p>${response.data.name}</p>
                <br>`;

            //adaugam html-ul pe pagina
            $('#basicCVDetails').append(html);
            $('#printtext #basics').append(html);
        }

        //verificam daca este setata macar o valoare dintre adresa, tara, oras, telefon sau email,
        //daca da, afisam titlul subsectiunii
        if (response.data.country != "" || response.data.email_contact != "" ||
            response.data.phone != "" || response.data.adress) {
            const html = `<h3>Contact Details</h3>`;
            $('#basicCVDetails').append(html);
            $('#printtext #basics').append(html);
        }

        //verificam pentru fiecare valoare daca este setata si o afisam
        let html = "";
        html += response.data.email_contact != "" ? `<p>${response.data.email_contact}` : "";
        html += response.data.phone != "" ? `<p>${response.data.phone}` : "";
        html += response.data.adress != "" ? `<p>${response.data.adress}` : "";
        html += response.data.country != "" ? `<p>${response.data.country}` : "";

        $('#basicCVDetails').append(html);
        $('#printtext #basics').append(html + "<hr>");

    }).catch((error) => {
        //intrare in raspuns de eroare

        //apelare functia showPopupError
        showPopupError(error.response.data.message);
    });

    //facem request la /api/education/get/{cv_id} pt a obtine informatiile despre educatie
    axios({
        url: `/api/education/get/${getCVIdFromURL()}`,
        method: 'get',
        baseUrl: `${localStorage.getItem('base_url')}`,
        headers: {
            'Authorization': `Bearer ${localStorage.getItem('key')}`
        }
    }).then((response) => {

        //preluam response-ul si generam html-ul
        response.data.forEach(element => {

            //verificam daca exista valori setate si daca da, concatenam stringul html care
            //il adaugam in pagina
            let html = "";
            html += element.school_name != "" ? `<h3>${element.school_name}</h3>` : "";
            html += element.adress != "" ? `<p>${element.adress}</p>` : "";
            html += element.start_year != "" && element.end_year != "" ? `<p>${element.start_year} - ${element.end_year}</p>` : "";
            html += element.section != "" ? `<p>${element.section}</p>` : "";

            html += html != "" ? '<br>' : "";

            $('#educationDetails').append(html);
            $('#printtext #education').append(html + "<hr>");

        });

    }).catch((error) => {
        //intrare in raspuns de eroare

        //apelare functia showPopupError
        showPopupError(error.response.data.message);
    });

    //facem request la /api/education/get/{cv_id} pt a obtine informatiile despre educatie
    axios({
        url: `/api/experience/get/${getCVIdFromURL()}`,
        method: 'get',
        baseUrl: `${localStorage.getItem('base_url')}`,
        headers: {
            'Authorization': `Bearer ${localStorage.getItem('key')}`
        }
    }).then((response) => {

        //preluam response-ul si generam html-ul
        response.data.forEach(element => {

            //verificam daca exista valori setate si daca da, concatenam stringul html care
            //il adaugam in pagina
            let html = "";
            html += element.company_name != "" ? `<h3>${element.company_name}</h3>` : "";
            html += element.adress != "" ? `<p>${element.adress}</p>` : "";
            html += element.start_year != "" && element.end_year != "" ? `<p>${element.start_year} - ${element.end_year}</p>` : "";
            html += element.job_position != "" ? `<p>${element.job_position}</p>` : "";

            html += html != "" ? '<br>' : "";

            $('#editExperience').append(html);
            $('#printtext #experience').append(html + "<hr>");

        });

    }).catch((error) => {
        //intrare in raspuns de eroare

        //apelare functia showPopupError
        showPopupError(error.response.data.message);
    });

    //facem request la /api/education/get/{cv_id} pt a obtine informatiile despre educatie
    axios({
        url: `/api/objective/get/${getCVIdFromURL()}`,
        method: 'get',
        baseUrl: `${localStorage.getItem('base_url')}`,
        headers: {
            'Authorization': `Bearer ${localStorage.getItem('key')}`
        }
    }).then((response) => {

        console.log(response.data); //pt debbug

        //creez un string gol
        let html = "";

        //adaug elemente in acel string
        html += response.data.position != "" ? `<p>${response.data.position}</p>` : "";
        html += response.data.time != "" ? `<p>${response.data.time}</p>` : "";
        html += response.data.domain != "" ? `<p>${response.data.domain}</p>` : "";
        html += response.data.company != "" ? `<p>${response.data.company}</p>` : "";

        //adaug string-ul generat in html
        $('#objectiveDetails').append(html); //adaug string ul generat in html pt site
        $('#printtext #objective').append(html + "<div style='width: 100%; border-bottom: 2px solid #000;'>");//adaug string ul generat in html pt pdf

    }).catch((error) => {
        //intrare in raspuns de eroare

        //apelare functia showPopupError
        showPopupError(error.response.data.message);
    });

    axios({
        url: `/api/interests/getAll/${getCVIdFromURL()}`,
        method: `get`,
        baseUrl: `${localStorage.getItem('base_url')}`,
        headers: {
            'Authorization': `Bearer ${localStorage.getItem('key')}`
        }
    }).then((response) => {

        console.log(response.data);

        let html = "";
        if (response.data.length > 0) {
            html += `<h3>Interests</h3>`;
        }

        response.data.forEach(element => {
            html += `<p>${element.interest_name} - ${element.description}</p>`
        });


        html += "<br>";

        $('#aboutyouContainer').append(html);
        $('#printtext #interests').append(html);

    }).catch((error) => {
        //intrare in raspuns de eroare

        //apelare functia showPopupError
        showPopupError(error.response.data.message);
    });

    axios({
        url: `/api/statement/get/${getCVIdFromURL()}`,
        method: `get`,
        baseUrl: `${localStorage.getItem('base_url')}`,
        headers: {
            'Authorization': `Bearer ${localStorage.getItem('key')}`
        }
    }).then((response) => {
        console.log(response.data);
        let html = `<h3>Personal Statement</h3>`;

        html += `<p>${response.data[0].statement_text.replace(/\n/g, "</p><p>")}</p>`;
        $('#aboutyouContainer').append(html);
        $('#printtext #aboutyou #statement').append(html + "<hr>");
    }).catch((error) => {
        //intrare in raspuns de eroare

        //apelare functia showPopupError
        showPopupError(error.response.data.message);
    });

    axios({
        url: `/api/skills/get/${getCVIdFromURL()}`,
        method: `get`,
        baseUrl: `${localStorage.getItem('base_url')}`,
        headers: {
            'Authorization': `Bearer ${localStorage.getItem('key')}`
        }
    }).then((response) => {
        console.log(response.data);

        let isTehnical = false,
            isPersonal = false;

        for (let index = 0; index < response.data.length; index++) {
            if (response.data[index].skill_type == "PERSONAL" && isPersonal == false) {
                isPersonal = true;
            }
            if (response.data[index].skill_type == "TEHNIC" && isTehnical == false) {
                isTehnical = true;
            }

            if (isTehnical && isPersonal) {
                break;
            }
        }

        let html = "";

        if (isTehnical) {
            html += "<h3>Technical Skills</h3>";
        }

        response.data.forEach(element => {
            if (element.skill_type == "TEHNIC") {
                html += `<p>${element.skill_name} - ${element.description}</p>`;
            }
        });

        if (isTehnical) {
            html += "<br>";
        }

        if (isPersonal) {
            html += "<h3>Personal Skills</h3>";
        }

        response.data.forEach(element => {
            if (element.skill_type == "PERSONAL") {
                html += `<p>${element.skill_name} - ${element.description}</p>`;
            }
        });

        $('#skillContainer').append(html);
        $('#printtext #skills').append(html + "<hr>");
    }).catch((error) => {
        //intrare in raspuns de eroare

        //apelare functia showPopupError
        showPopupError(error.response.data.message);
    });
}

readyFunctionByPageName['builder/editBasic'] = function () {

    //facem request la /api/cv/get/{id}
    axios({
        url: `/api/cv/get/${getCVIdFromURL()}`,
        method: 'get',
        baseUrl: `${localStorage.getItem('base_url')}`,
        headers: {
            'Authorization': `Bearer ${localStorage.getItem('key')}`
        }
    }).then((response) => {

        //setam valoarea pentru fiecare inm
        $('#nameInput').val(response.data.name);
        $('#emailInput').val(response.data.email_contact);
        $('#phoneInput').val(response.data.phone);
        $('#adressInput').val(response.data.adress);
        $('#countryInput').val(response.data.country);


    }).catch((error) => {
        //intrare in raspuns de eroare

        //apelare functia showPopupError
        showPopupError(error.response.data.message);
    });
}

readyFunctionByPageName['builder/editObjective'] = function () {

    //facem request la /api/cv/get/{id}
    axios({
        url: `/api/objective/get/${getCVIdFromURL()}`,
        method: 'get',
        baseUrl: `${localStorage.getItem('base_url')}`,
        headers: {
            'Authorization': `Bearer ${localStorage.getItem('key')}`
        }
    }).then((response) => {

        //setam valoarea pentru fiecare input
        $('#position').val(response.data.position);
        $('#time').val(response.data.time);
        $('#company').val(response.data.company);
        $('#domain').val(response.data.domain);
        $('#id').val(response.data.pk_id);

    }).catch((error) => {
        //intrare in raspuns de eroare

        //apelare functia showPopupError
        showPopupError(error.response.data.message);
    });
}

readyFunctionByPageName['builder/aboutyouEdit'] = function () {
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
            return;
        }

        response.data.forEach(element => {
            const randomId = generateRandomId(10);

            let html = `<div class="row interestItems" id="${randomId}" data-editable="true" data-id="${element.pk_id}">
                <div class="form-group col-md-4">
                    <input type="text" placeholder="Interest" class="form-control custom-input"
                        id="interest_name" value="${element.interest_name}" aria-describedby="emailHelp">
                </div>
                <div class="form-group col-md-6">
                    <input type="text" placeholder="Description" class="form-control custom-input"
                        id="description" value="${element.description}" aria-describedby="emailHelp">
                </div>
                <div class="col-md-2">
                    <button onclick="removeInterests(${element.pk_id}, '${randomId}')" class="btn btn-primary removeButtonLine">Remove</button>
                </div>
            </div>`;

            $('#interestsContainer').append(html);

        });

    }).catch((error) => {
        //intrare in raspuns de eroare

        //apelare functia showPopupError
        showPopupError(error.response.data.message);
    });

    //facem request la /api/cv/get/{id}
    axios({
        url: `/api/statement/get/${getCVIdFromURL()}`,
        method: 'get',
        baseUrl: `${localStorage.getItem('base_url')}`,
        headers: {
            'Authorization': `Bearer ${localStorage.getItem('key')}`
        }
    }).then((response) => {
        $('#statement').append(response.data[0].statement_text);

    }).catch((error) => {
        //intrare in raspuns de eroare

        //apelare functia showPopupError
        showPopupError(error.response.data.message);
    });
}

readyFunctionByPageName['builder/skillsEdit'] = function () {
    axios({
        url: `/api/skills/get/${getCVIdFromURL()}`,
        method: `get`,
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
                const html = `<div class="row technicalItems" id="${randomId}" data-type="TEHNIC" data-editable="true" data-id="${element.pk_id}">
                        <div class="form-group col-md-4">
                            <input type="text" placeholder="Skill Name" class="form-control custom-input"
                                id="skill_name" value="${element.skill_name}" aria-describedby="emailHelp">
                        </div>
                        <div class="form-group col-md-6">
                            <input type="text" placeholder="Description" class="form-control custom-input"
                                id="description" value="${element.description}" aria-describedby="emailHelp">
                        </div>
                        <div class="col-md-2">
                            <button onclick="removeSkills(${element.pk_id}, '${randomId}')" class="btn btn-primary removeButtonLine">Remove</button>
                        </div>
                    </div>`;

                $('#TechnicalContainer').append(html);
            }
            if (element.skill_type == "PERSONAL") {
                existsPersonal = true;
                const html = `<div class="row personalItems" id="${randomId}" data-type="PERSONAL" data-editable="true" data-id="${element.pk_id}">
                        <div class="form-group col-md-4">
                            <input type="text" placeholder="Skill Name" class="form-control custom-input"
                                id="skill_name" value="${element.skill_name}" aria-describedby="emailHelp">
                        </div>
                        <div class="form-group col-md-6">
                            <input type="text" placeholder="Description" class="form-control custom-input"
                                id="description" value="${element.description}" aria-describedby="emailHelp">
                        </div>
                        <div class="col-md-2">
                            <button onclick="removeSkills(${element.pk_id}, '${randomId}')" class="btn btn-primary removeButtonLine">Remove</button>
                        </div>
                    </div>`;

                $('#PersonalContainer').append(html);
            }
        });

        if (existsTehnic == false) {
            addTechnicalSkill();
        }

        if (existsPersonal == false) {
            addPersonalSkill();
        }

    }).catch((error) => {
        //intrare in raspuns de eroare

        //apelare functia showPopupError
        showPopupError(error.response.data.message);
    });
}

readyFunctionByPageName['builder/editEducation'] = function () {

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
            return;
        }
        //preluam response-ul si generam html-ul
        response.data.forEach(element => {

            const randomId = generateRandomId(10);
            //verificam daca exista valori setate si daca da, concatenam stringul html care
            //il adaugam in pagina

            const html = `    <div class="container margin-top-100 educationItems" id="${randomId}" data-editable="true" data-id="${element.pk_id}">
            <div class="row align-items-center">
                <div class="col-12 mx-auto">
                    <div class="jumbotron center-section-container shadow p-3">
    
                        <h2>Education</h2>
    
                        <div class="row">
                            <div class="form-group col-md-6">
                                <input type="text" placeholder="School Name" value="${element.school_name}" class="form-control custom-input"
                                    id="school_name" aria-describedby="emailHelp">
                            </div>
                            <div class="form-group col-md-6">
                                <input type="text" placeholder="Address" value="${element.adress}" class="form-control custom-input"
                                    id="adress" aria-describedby="emailHelp">
                            </div>
                            <div class="form-group col-md-6">
                                <input type="text" placeholder="Start Year" value="${element.start_year}" class="form-control custom-input"
                                    id="start_year" aria-describedby="emailHelp">
                            </div>
                            <div class="form-group col-md-6">
                                <input type="text" placeholder="End Year" value="${element.end_year}" class="form-control custom-input"
                                    id="end_year" aria-describedby="emailHelp">
                            </div>
                            <div class="form-group col-md-6">
                                <input type="text" placeholder="Section" value="${element.section}" class="form-control custom-input"
                                    id="section" aria-describedby="emailHelp">
                            </div>
                        </div>
    
                        <button onclick="addEducation()" class="btn btn-primary">Add</button>
                        <button onclick="removeEducation(${element.pk_id}, '${randomId}')" class="btn btn-primary removeButton">Remove</button>
                                        <!--id ul din baza de date  -->    <!--id ul din html  -->
                    </div>
                </div>
            </div>
        </div>`;

            $('#containerEducation').append(html);

        });


    }).catch((error) => {
        //intrare in raspuns de eroare

        //apelare functia showPopupError
        showPopupError(error.response.data.message);
    });
}

readyFunctionByPageName['builder/editExperience'] = function () {

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
            return;
        }
        //preluam response-ul si generam html-ul
        response.data.forEach(element => {

            console.log("intru aici");
            const randomId = generateRandomId(10);
            //verificam daca exista valori setate si daca da, concatenam stringul html care
            //il adaugam in pagina

            const html = `    <div class="container margin-top-100 experienceItems" id="${randomId}" data-editable="true" data-id="${element.pk_id}">
            <div class="row align-items-center">
                <div class="col-12 mx-auto">
                    <div class="jumbotron center-section-container shadow p-3">
    
                        <h2>Experience</h2>
    
                        <div class="row">
                            <div class="form-group col-md-6">
                                <input type="text" placeholder="Company Name" value="${element.company_name}" class="form-control custom-input"
                                    id="company_name" aria-describedby="emailHelp">
                            </div>
                            <div class="form-group col-md-6">
                                <input type="text" placeholder="Address" value="${element.adress}" class="form-control custom-input"
                                    id="adress" aria-describedby="emailHelp">
                            </div>
                            <div class="form-group col-md-6">
                                <input type="text" placeholder="Start Year" value="${element.start_year}" class="form-control custom-input"
                                    id="start_year" aria-describedby="emailHelp">
                            </div>
                            <div class="form-group col-md-6">
                                <input type="text" placeholder="End Year" value="${element.end_year}" class="form-control custom-input"
                                    id="end_year" aria-describedby="emailHelp">
                            </div>
                            <div class="form-group col-md-6">
                                <input type="text" placeholder="Position" value="${element.job_position}" class="form-control custom-input"
                                    id="position" aria-describedby="emailHelp">
                            </div>
                        </div>
    
                        <button onclick="addExperience()" class="btn btn-primary">Add</button>
                        <button onclick="removeExperience(${element.pk_id}, '${randomId}')" class="btn btn-primary removeButton">Remove</button>
    
                    </div>
                </div>
            </div>
        </div>`;

            $('#containerExperience').append(html);

        });


    }).catch((error) => {
        //intrare in raspuns de eroare

        //apelare functia showPopupError
        showPopupError(error.response.data.message);
    });
}

//functie care se apeleaza la incarcarea paginii
$(document).ready(function () {
    if(localStorage.getItem('key') == undefined){
        let html = `             <li>
            <a href="${localStorage.getItem('base_url')}/account/login"><i
                    class="fas fa-sign-out-alt"></i> Login</a>
        </li><li>
            <a href="${localStorage.getItem('base_url')}/account/register"><i
                    class="fas fa-sign-out-alt"></i> Register</a>
        </li>`

        

        $('#loginButtons').append(html)
    }
    else{
        let html = `<li>
            <a onclick="logoutFunction()"><i
                    class="fas fa-sign-out-alt"></i> Logout</a>
        </li>`

        $('#loginButtons').append(html)
    }

    //functii pentru sidebar
    $("#sidebar").mCustomScrollbar({
        theme: "minimal"
    });

    $('#dismiss, .overlay').on('click', function () {
        // hide sidebar
        $('#sidebar').removeClass('active');
        // hide overlay
        $('.overlay').removeClass('active');
    });

    $('#sidebarCollapse').on('click', function () {
        // open sidebar
        $('#sidebar').addClass('active');
        // fade in the overlay
        $('.overlay').addClass('active');
        $('.collapse.in').toggleClass('in');
        $('a[aria-expanded=true]').attr('aria-expanded', 'false');
    });


    //prin localStorage.getItem() preiau(get) pagina unde este utilizatorul
    //valoarea setata in layout, primita din controller
    //verific daca exista ceva de executat pentru aceasta pagina, daca da, execut codul 
    if (readyFunctionByPageName[localStorage.getItem('curent_page')] != undefined) {
        readyFunctionByPageName[localStorage.getItem('curent_page')]();
    }

});

