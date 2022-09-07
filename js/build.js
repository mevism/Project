    const ServerData = new (function(){
        this.bindAuth = async function(r, h, c, m, f){
            let pop = { method : r }
            if(r == "POST") {
                if(!f)
                    pop.body = JSON.stringify(m)
                else
                    pop.body = m
            }
            if(c)
                pop.headers = { 'Content-type': 'application/json; charset=UTF-8', 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
            else
                pop.headers = { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
            try {
                const response = await fetch( h, pop );
                const tears = await response.json();
                return tears;

            } catch (error) {
                console.log(error);
            }
        };
        this.UPSTREAM = async() => {
            let collect = await this.bindAuth('GET',document.querySelector('meta[name="oneui-route"]').content,false)
            return collect;
        };
        this.buildSelect = (e) => {
            let { id, placeholder, data } = e

            $(id).select2({
                placeholder : placeholder,
                tags : true,
                //templateSelection : formatState,
                data : data
            }).on('select2:close', function(){
                var element = $(this);
                var new_category = $.trim(element.val().split(',')[1]);

                if(id == "#intake_name"){
                    $('#intake2').fadeIn('slow')
                    $('#intake1').fadeOut('slow')
                    $('#current').html(new_category)
                    ServerData.nextPrompt(1,"#intake_name")
                }
                if(id == "#approve_intake_name"){
                    $('#intake2').fadeIn('slow')
                    $('#intake1').fadeOut('slow')
                    $('#current').html(new_category)
                    ServerData.nextPrompt(2,"#approve_intake_name")
                }
                if(id == "#attendance_search" || id == "#study_search" || id == "#stage_search" || id == "#course_search")
                    ServerData.beApproved(1,1)
                if(id == "#page_approve")
                    ServerData.beApproved($.trim(element.val().split(',')[0]),0)

                if(id == "#all_intake")
                    plotCourses()
                if(id == "#all_course"){
                    console.log('Hey')
                    plotClasses()
                }

            });
        };
        this.plotLegend = (e) => {
            const { id, value } = e
            if(value)
                $(id).slideDown('slow')
            else
                $(id).slideUp('slow')
        };
        this.getAge = function(dateString) {
            var today = new Date();
            var birthDate = new Date(dateString);
            var age = today.getFullYear() - birthDate.getFullYear();
            var m = today.getMonth() - birthDate.getMonth();
            if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
                age--;
            }
            return age;
        }
        this.validate = (a) => {
            let proceed = true;
            a.map( data => {
                if(!data.value){
                    $('#feedback-apply').append('<h4>' + data.name + '</h4>')
                    proceed = false
                }
            })
            return proceed;
        };
        this.getSum = function(total, num) {
               return total + Math.ceil(num);
        };
        this.gone = function(){
            $('#fill-modal').remove()
            const element = document.getElementById("fill-modal");
            if (element)
                element.remove();
        }
        this.popUp = (e) => {
            const { msg, img, func, dump } = e
            $('#page-container').append(`
                <div id = 'fill-modal'>
                    <div id = 'inner-fill-modal'>
                        <img src = '${ ServerData.PICS[img] }' style = 'width : 40%;height:40%;'>
                        ${ msg }
                        <div style = 'width : 96%;margin:2%;display:flex;'>
                            <button id = '${ func }' class = 'btn btn-alt-success' style = 'height:40px!important;width:48%;margin:1%;' dublin = '${ JSON.stringify(dump) }'>YES</button>
                            <button onclick = 'ServerData.gone()' class = 'btn btn-alt-danger' style = 'height:40px!important;width:48%;margin:1%;'>NO</button>
                        </div>
                    </div>
                </div>
            `)
        };
        this.modalMsg = (e) => {
            const { msg, mode, callback } = e
            let img = ServerData.PICS[0]
            if(!mode)
                img = ServerData.PICS[1]
            $('#page-container').append(`
                <div id = 'fill-modal'>
                    <div id = 'inner-fill-modal'>
                        <img src = '${ img }' style = 'width : 40%;height:40%;'>
                        ${ msg }
                    </div>
                </div>
            `)
            setTimeout(
                function(){
                    $('#fill-modal').remove()
                    const element = document.getElementById("fill-modal");
                    if(element)
                        element.remove();
                }
                ,2000)
        };
        this.generatePDF = (e) => {
            const { file, body} = e
            let opt = {
                margin: 1,
                filename: file,
                image: {
                    type: 'jpeg',
                    quality: 0.98
                },
                html2canvas: {
                    scale: 2
                },
                jsPDF: {
                    unit: 'in',
                    format: 'tabloid',
                    orientation: 'landscape'
                }
            };
            html2pdf().from(body).set(opt).save();
        };
    })()

    const retrieveApplication = async(e) => {
        let { status, role } = e
        let type = "Pending"
        let id = "0"
        if(role == 4)
            id = "9,6"
        if(status === 1){
            type = "Approved"
            if(role == 2)
                id = "1,6"
            if(role == 4)
                id = "3,5,7"
        }
        if(status === 2){
            type = "Rejected"
            if(role == 2)
                id = "2,9"
            if(role == 4)
                id = "4,8,10"
        }
        let list_data = await ServerData.bindAuth('POST',`./fetchData`,true,{ id })
        console.log(list_data)
        let list_string = `<div id = 'time-out'><img src = './../Images/clipboard.svg'>No ${type} lists</div>`
        if(list_data.list.length > 0){
            list_string = list_data.list.map(p =>
                `
                    <div id = 'application-list'>
                        <section>
                            <p> <i class="fa-solid fa-calendar" style = 'font-size:120%;'></i> <b style = 'font-size:120%;'>Intake List</b>  <i class='fas fa-caret-right' style = 'font-size:120%;'></i> ${ p.name }</p>
                        </section>
                        ${ p.academic.map( a =>
                            `
                                <section class = 'academics'>
                                    <div>
                                        <h5>Academic Program</h5>
                                        <p>${ ServerData.studies[ a.program ] }</p>
                                    </div>
                                    <div>
                                        <h5>Number ${ type }</h5>
                                        <p>${ a.number }</p>
                                    </div>
                                    <div>
                                        <button id = 'view-application-list' app = '${ p.intake }' program = '${ a.program }' status = '${ id }' name = '${ p.name }' class = 'btn btn-alt-info' data-toggle = 'click-ripple'>
                                            View
                                        </button>
                                    </div>
                                </section>
                            `
                        )}
                        <section class = 'footer-list'>
                            <div>
                                <p>Start : ${ p.start }</p>
                                <p>End : ${ p.end }</p>
                                <p>${ (p.expire) ? "Intake in session" : "Intake Not in session" }</p>
                            </div>
                            <div>
                                ${ ([9,6].includes(p.status)) ? "List Has Been Pushed By COD" :([0].includes(p.status)) ? "No action taken on list" : ([7,10].includes(p.status)) ? "List Has Been Pushed By DEAN" : `<button id = 'push-list' list = '${ p.intake }' status = '${ p.status }' class = 'btn btn-alt-info' data-toggle = 'click-ripple'>Push List</button>` }
                                <button id = 'print-approval' type = '${ id }' intake = '${ p.name }'  class = 'btn btn-info' ><i class="fa-solid fa-file-pdf" style="font-size:120%;"></i> Print</button>                            
                            </div>
                        </section>
                    </div>
                `
            )
        }
        $('.content-force').html(list_string)
    }

    const showCourses = async() => {
        let collect = await ServerData.bindAuth('GET',`./getIntakes`,false)
        console.log(collect)
        ServerData.buildSelect({'id' : '#all_intake', 'placeholder' : 'Intakes', 'data' : collect.data })
        plotCourses()
    }

    const showReport = async() => {
        let collect = await ServerData.bindAuth('GET',`./allCourses`,false)
        console.log(collect)
        ServerData.buildSelect({'id' : '#all_course', 'placeholder' : 'Courses', 'data' : collect.course })
        plotClasses()
    }
    const plotClasses = async() => {

        const course = $('#all_course').val().split(',')[0]
        let collect = await ServerData.bindAuth('POST',`./getReport`,true,{ course })
        console.log(collect)
        let plot_string = "<h5>There is no classes for this course</h5>"
        if(!collect.report.includes(false)) {
            plot_string = "There are no records"
            if(collect.report.length > 0) {
                plot_string = collect.report.map( (c,class_key) =>
                    `
                        <section>
                            <i class='fas fa-screen-users' style = 'font-size:350%;'></i>
                            <p>Class : ${ c.class }</p>
                            <div id = 'hold-info'>
                                <section>
                                    <div id = 'hold-line'>
                                        INTAKE
                                    </div>
                                    <div id = 'hold-line'>
                                        FROM
                                    </div>
                                    <div id = 'hold-line'>
                                        TO
                                    </div>
                                    <div id = 'hold-line'>
                                        SEMESTER
                                    </div>
                                    <div id = 'hold-line'>
                                        YEAR
                                    </div>
                                    <div id = 'hold-line'>
                                        VIEW SESSION
                                    </div>
                                </section>
                            </div>
                            <div id = 'hold-info'>
                            ${
                                c.intake.map((i, k) =>
                                    `
                                        <section style = '${ (k%2) ? 'background::#fff':'background:rgba(234,234,234,0.7)' }'>
                                             <p id = '${ (k%2) ? 'hold-line' : 'hold-line-bar'}'>${ i }</p>
                                             <p id = '${ (k%2) ? 'hold-line' : 'hold-line-bar'}'>${ c.intakes_from[k] }</p>
                                             <p id = '${ (k%2) ? 'hold-line' : 'hold-line-bar'}'>${ c.intakes_to[k] }</p>
                                             <p id = '${ (k%2) ? 'hold-line' : 'hold-line-bar'}'>${ c.semester[k] }</p>
                                             <p id = '${ (k%2) ? 'hold-line' : 'hold-line-bar'}'>${ c.year[k] }</p>
                                             <div id = 'hold-line'>
                                                <button id = 'view-sessions' index = '${ class_key }${ k }' status = 'false' class = 'btn btn-sm btn-alt-info' data-ripple = ''>VIEW SESSIONS</button>
                                            </div>
                                        </section>
                                        <section id = 'session-add${ class_key }${ k }' style = 'display : none'>
                                            ${
                                                c.status[k].map( s => `<div id = 'remove-session' data-status = '${ s }' data-intake = '${ c.intake_id[k] }' data-class = '${ c.year[k] }' data-course = '${ course }' class = '${ (s == "IN SESSION")? 'btn btn-sm btn-alt-success' : (s == "ONLINE SESSION") ? 'btn btn-sm btn-alt-success' :  (s == "WORKSHOP") ? 'btn btn-sm btn-alt-success' : 'btn btn-sm btn-alt-danger'}' style = 'margin:1%;'>${ s }<p>Remove</p></div>`).join('')
                                            }
                                            <button id = 'confirm-class-box' data-class = '${ c.class_id }' data-intake = '${ c.intake_id[k] }' class = 'btn btn-sm btn-alt-info' data-ripple>ADD SESSION</button>                                           
                                        </section>
                                    `
                                ).join('')
                            }
                            </div>
                        </section>
                        
                    `
                )
            }
        }
        $('#report-page').html(plot_string)
    }
    const getCourses = async() => {

        let checkProgress = await ServerData.bindAuth('GET',`./checkChange`,false)
        if(checkProgress.response) {
            let collect = await ServerData.bindAuth('GET',`./getTransferLogs`,false)

            let transfers =
                `
                    <h4><i class="fa-solid fa-spinner"></i> Application Progress</h4>
                    <section style = 'text-align:center;display:flex;flex-wrap:wrap;width:80%;margin-left:10%;background:rgba(234,234,234,0.6);border:1px solid #fff;'>
                        <div style ='width:19%;margin:0.5%;'>
                            <h4>USER</h4>
                        </div>
                        <div style ='width:19%;margin:0.5%;'>
                            <h4>ACTION</h4>
                        </div>
                        <div style ='width:19%;margin:0.5%;'>
                            <h4>DATE</h4>
                        </div>
                        <div style ='width:19%;margin:0.5%;'>
                            <h4>REASON</h4>
                        </div>
                        <div style ='width:19%;margin:0.5%;'>
                            <h4>STATUS</h4>
                        </div>
                    </section>
                `

            if(screen.width >= 856 ) {

                transfers += collect.transfers.map( (transfer,key) =>
                    `${
                        transfer.map((t, k) =>
                            `
                                <section style = 'text-align:center;width:80%;margin-left:10%;display:flex;flex-wrap:wrap;${ (key > 0) ? ((collect.transfers[0].length + k) % 2) ? 'background:rgba(234,234,234,0.6);border:1px solid #fff;' : 'background:#fff;border:1px solid rgba(234,234,234,0.6);' : (k % 2) ? 'background:rgba(234,234,234,0.6);border:1px solid #fff;' : 'background:#fff;border:1px solid rgba(234,234,234,0.6);'}'>
                                    <div style ='width:19%;margin:0.5%;'>
                                        <p>${ t.level }</p>
                                    </div>
                                    <div style ='width:19%;margin:0.5%;'>
                                        ${ ( t.status == 0 ) ? `<p class = 'btn btn-sm btn-alt-info'>PENDING COD ACTION</p>` : (t.status == 1) ? `<p class = 'btn btn-sm btn-alt-success'>COD APPROVED</p>` : (t.status == 2) ? `<p class = 'btn btn-sm btn-alt-danger'>COD REJECTED</p>` : (t.status == 3) ? `<p class = 'btn btn-sm btn-alt-info'>APPROVED BY COD, PENDING DEAN APPROVAL</p>` : (t.status == 4) ? `<p class = 'btn btn-sm btn-alt-success'>COD AND DEAN APPROVED</p>` : (t.status == 5) ? `<p class = 'btn btn-sm btn-alt-danger'>DEAN REJECTED</p>` : (t.status == 6) ? `<p class = 'btn btn-sm btn-alt-info'>APPROVED BY COD AND DEAN PENDING REGISTRAR</p>` : (t.status == 7) ? `<p class = 'btn btn-sm btn-alt-danger'>REGISTRAR REJECTED</p>` : (t.status == 8) ? `<p class = 'btn btn-sm btn-alt-success'>APPROVED BY COD, DEAN AND REGISTRAR</p>` : `<p class = 'btn btn-sm btn-alt-danger'>ERROR</p>`}</p>
                                    </div>
                                    <div style ='width:19%;margin:0.5%;'>
                                        <p>${ t.date }</p>
                                    </div>
                                    <div style ='width:19%;margin:0.5%;'>
                                        <p>${ t.reason }</p>
                                    </div>   
                                    <div style ='width:19%;margin:0.5%;'>
                                        ${ ( t.status == 0 ) ? `<p class = 'btn btn-sm btn-alt-success'>Opened</p>` : `<p class = 'btn btn-sm btn-alt-danger'>Closed</p>`}
                                    </div>                    
                                </section>
                            `
                        ).join('')
                    }
                    `
                ).join('')
            }else{
                transfers = collect.transfers.map((transfer,key) =>
                    `
                    ${
                        transfer.map((t, k) =>

                            `
                                <section style = 'text-align:center;width:100%;display:flex;flex-wrap:wrap;${ (key > 0) ? ((collect.transfers[0].length + k) % 2) ? 'background:rgba(234,234,234,0.6);border:1px solid #fff;' : 'background:#fff;border:1px solid rgba(234,234,234,0.6);' : (k % 2) ? 'background:rgba(234,234,234,0.6);border:1px solid #fff;' : 'background:#fff;border:1px solid rgba(234,234,234,0.6);'}'>
                                    <div style ='width:48%;margin:0.5%;'>
                                        <h4>USER</h4>
                                        <p>${ t.level }</p>
                                    </div>
                                    <div style ='width:48%;margin:0.5%;'>
                                        <h4>ACTION</h4>
                                        ${ ( t.status == 0 ) ? `<p class = 'btn btn-sm btn-alt-info'>PENDING COD ACTION</p>` : (t.status == 1) ? `<p class = 'btn btn-sm btn-alt-success'>COD APPROVED</p>` : (t.status == 2) ? `<p class = 'btn btn-sm btn-alt-danger'>COD REJECTED</p>` : (t.status == 3) ? `<p class = 'btn btn-sm btn-alt-info'>APPROVED BY COD, PENDING DEAN APPROVAL</p>` : (t.status == 4) ? `<p class = 'btn btn-sm btn-alt-success'>COD AND DEAN APPROVED</p>` : (t.status == 5) ? `<p class = 'btn btn-sm btn-alt-danger'>DEAN REJECTED</p>` : (t.status == 6) ? `<p class = 'btn btn-sm btn-alt-info'>APPROVED BY COD AND DEAN PENDING REGISTRAR</p>` : (t.status == 7) ? `<p class = 'btn btn-sm btn-alt-danger'>REGISTRAR REJECTED</p>` : (t.status == 8) ? `<p class = 'btn btn-sm btn-alt-success'>APPROVED BY COD, DEAN AND REGISTRAR</p>` : `<p class = 'btn btn-sm btn-alt-danger'>ERROR</p>`}</p>
                                    </div>
                                    <div style ='width:48%;margin:0.5%;'>
                                        <h4>DATE</h4>
                                        <p>${ t.date }</p>
                                    </div>
                                    <div style ='width:48%;margin:0.5%;'>
                                        <h4>REASON</h4>
                                        <p>${ t.reason }</p>
                                    </div>  
                                    <div style ='width:48%;margin:0.5%;'>
                                        <h4>STATUS</h4>
                                        ${ ( t.status == 0 ) ? `<p class = 'btn btn-sm btn-alt-success'>Opened</p>` : `<p class = 'btn btn-sm btn-alt-danger'>Closed</p>`}
                                    </div>                    
                                </section>
                            `
                        ).join('')
                    }
                    `
                ).join('')

            }
            $('#course_interaction').html(transfers)
        }else{
            $('#course_interaction').html(
                `
                    <div class="col-12 col-xl-12">
                        <div id = 'add-on-l_name' style = 'display:none;'><i class='fas fa-home'></i> Cut Off Points *</div>
                        <input type = 'text' carry-index = '#add-on-l_name' placeholder="Cut Off Points *" id = 'cut_off_value' >
                    </div>
                    <div class="col-12 col-xl-12">
                        <select class = 'select_approve' id = 'cut_off_approve' name = 'cut_off_approve' style = 'width:50%;margin-left:25%;'></select>
                    </div>
                    <div class="col-12 col-xl-12">
                        <button id = 'check-course'  class = 'btn btn-sm btn-alt-info' data-ripple = '' style = 'width:50%;height:40px'>Submit</button>
                    </div>
                `
            )
            let collect = await ServerData.bindAuth('GET',`./getCourses`,false)
            console.log(collect)
            ServerData.buildSelect({ 'id' : '#cut_off_approve', 'placeholder' : 'Courses Available', 'data' : collect.course })
        }
    }
    const plotCourses = async() => {
        const intake = $('#all_intake').val().split(',')[0]
        let collect = await ServerData.bindAuth('POST',`./getCourses`,true,{ intake })
        let plot_string = "No courses available for this department in the registrar database"
        if(collect.course.length > 0) {
            plot_string = `
                <section id = 'courses-section'>
                    <div style = 'border:1px solid #ccc'>
                        <span>COURSE NAME</span>
                    </div>
                    <div style = 'border:1px solid #ccc'>
                        <span>COURSE CODE</span>
                    </div>
                    <div style = 'border:1px solid #ccc'>
                        <span>ADD/REMOVE COURSE</span>
                    </div>
                    <div style = 'border:1px solid #ccc'>
                        <span>EDIT ATTENDANCE</span>
                    </div>
                    <div style = 'border:1px solid #ccc'>
                        <span>EDIT CLASS</span>
                    </div>
                </section>
            `
            plot_string += collect.course.map( (c,key) =>
                `
                <section style = '${(key%2) ? 'background:#fff' : 'background:rgba(234,234,234,0.7)' }'>
                    <div id = 'courses-section'>
                        <div>                           
                            <p>${ c.courses[0].name }</p>
                        </div>
                        <div>                            
                            <p>${ c.courses[0].code }</p> 
                        </div> 
                        <button id = 'confirm-box' index = '${c.courses[0].id}' status = '${c.courses[0].status}' class = '${(c.courses[0].status) ? 'btn btn-sm btn-alt-success' : 'btn btn-sm btn-alt-danger'}'>
                             ${ (c.courses[0].status) ? 'Remove Course' : 'Select Course' }
                        </button> 
                        <button id = 'view-attendance' iteration = '${ key }' chosen = 'false' class = 'btn btn-sm btn-alt-primary'>View Attendance</button>                                              
                        <button id = 'view-class' iteration = '${ key }' chosen = 'false' class = 'btn btn-sm btn-alt-primary'>View Years</button>                                              
                    </div>
                    <div id = 'attendance-section' class = 'attendance-section${ key }'>
                        <p>Attendances allowed in intake</p>
                        <div = 'attendance-build'>
                        ${
                            (c.attendances.length > 0)
                            ?
                                `
                                ${
                                    c.attendances.map(a =>
                                        `
                                            <button id = '${(c.courses[0].status) ? 'confirm-attendance-box' : 'attendant-button'}' index = '${ a.id }' status = '${ a.status }' class = '${(a.status) ? 'box-in' : 'box-out'}' course = '${ a.course }'>
                                                <i class='fas fa-users' style = 'font-size:350%;'></i>
                                                <p>${ a.name }</p>
                                                <p>${ a.code }</p>
                                            </button>                                
                                        `
                                    ).join('')
                                }
                                `
                            :
                                `There are no attendances for this course`
                        }
                        </div>
                    </div>
                    
                    <div id = 'years-section' class = 'class-section${ key }'>
                        <p>Please select years allowed for the intake</p>
                        <div id = 'attendance-build'>
                            ${
                            (c.years.length > 0)
                            ?
                                `
                                ${
                                    c.years.map(y =>
                                        `
                                            <button id = '${ (c.courses[0].status) ? 'confirm-years-box' : 'attendant-button'}' index = '${ y.id }' status = '${ y.status }' class = '${(!y.status) ? 'box-out' : 'box-in'}' course = '${ y.course }'>
                                                <p>Year ${ y.name }</p>
                                            </button>                               
                                        `
                                    ).join('')
                                }
                                `
                            :
                            `There are no years selected for this course`
                        }
                        </div>                    
                    </div>    
                </section>
            `
            ).join('')
            plot_string += '</div>'
        }

        $('#course-page').html(plot_string)
    }
    const retrievePost = async() => {
        const app = sessionStorage.getItem('appId')
        const program = sessionStorage.getItem('programId')
        const name = sessionStorage.getItem('nameIntake')

        let collect = await ServerData.bindAuth('POST',`./getApplication`,true,{ 'app' : app })
        console.log(collect)
        ServerData.collect = collect.app
        let courses = collect.courses
        let attendance = collect.attendances
        let years = collect.years

        $('#intake_name').html(name)
        $('#intake_program').html(ServerData.studies[program])

        let stage_data = []
        if(years.length > 0){
            if(years[0].length > 0){
                years[0].map(data => {
                    stage_data.push({ 'id' : Number(data.years) + ',' + data.years, 'text' : data.years })
                })
            }
        }

        let course_data = []
        if(courses.length > 0){
            courses.map((data, key) => {
                course_data.push({ 'id' : Number(data[0].id) + ',' + data[0].course_name, 'text' : data[0].course_name })
            })
        }
        let attendance_data = []
        if(attendance.length > 0){
            attendance.map((data) => {
                attendance_data.push({ 'id' : data[0].id + ',' + data[0].attendance_name, 'text' : data[0].attendance_name })
            })
        }
        console.log(attendance_data)
        ServerData.buildSelect({ 'id' : '#attendance_search', 'placeholder' : 'Preferred Attendance(Select)*', 'data' : attendance_data })
        ServerData.buildSelect({ 'id' : '#course_search', 'placeholder' : 'Programme/Course(Select)*', 'data' : course_data })
        ServerData.buildSelect({ 'id' : '#stage_search', 'placeholder' : 'Year of Study*', 'data' : stage_data })
        ServerData.beApproved(1,0);
    }
    const plotProfile = async(e) => {
        let profile_data = await ServerData.bindAuth('GET',`./student_profile`,false)
        if(!profile_data)
            profile_data = await ServerData.bindAuth('GET',document.location.href + '/student_profile',false)
        let profile_string = profile_data.user.map( p =>
        `
            <ul class="timeline timeline-alt py-0" style = 'width:100%;'>
                <li class="timeline-event">
                    <div class="timeline-event-icon bg-default">
                        <i class="fa fa-user-gear"></i>
                    </div>
                    <div class="timeline-event-block block">
                        <div class="block-header">
                            <h3 class="block-title">Personal Info</h3>
                            <div class="block-options">
                                <div class="timeline-event-time block-options-item fs-sm">
                                    <i class="fa fa-info" title="user information"></i>
                                </div>
                            </div>
                        </div>
                        <div style = 'display : flex;flex-direction : row;'>
                            <section style = 'text-align:center;'>
                                <i class="fa-solid fa-user" id = 'fas_update'></i>
                                <h3 class = 'h3_update'>Name</h3>
                                <p>${ p.fname + ',' + p.mname + ',' + p.sname }</p>
                            </section>
                            <section style = 'text-align:center;'>
                                <i class="fa-solid fa-user" id = 'fas_update'></i>
                                <h3 class = 'h3_update'>Registration Number</h3>
                                <p>${ p.reg_number }</p>
                            </section>
                            <section style = 'text-align:center;'>
                                <i class="fa-solid fa-genderless" id = 'fas_update'></i>
                                <h3 class = 'h3_update'>Gender</h3>
                                <p>${ p.gender }</p>
                            </section>
                        </div>
                    </div>
                </li>
                <li class="timeline-event">
                    <div class="timeline-event-icon bg-modern">
                        <i class="fa fa-contact-card"></i>
                    </div>
                    <div class="timeline-event-block block">
                        <div class="block-header">
                            <h3 class="block-title">Contact Info</h3>
                            <div class="block-options">
                                <div class="timeline-event-time block-options-item fs-sm">
                                    <i class="fa fa-info" title="user information"></i>
                                </div>
                            </div>
                        </div>
                        <div style = 'display : flex;flex-direction : row;'>
                            <section style = 'text-align:center;'>
                                <i class="fa-solid fa-at" id = 'fas_update'></i>
                                <h3 class = 'h3_update'>Email</h3>
                                <p>${ p.email }</p>
                            </section>
                            <section style = 'text-align:center;'>
                                <i class="fa-solid fa-at" id = 'fas_update'></i>
                                <h3 class = 'h3_update'>Student Email</h3>
                                <p>${ p.student_email }</p>
                            </section>
                            <section style = 'text-align:center;'>
                                <i class="fa-solid fa-phone" id = 'fas_update'></i>
                                <h3 class = 'h3_update'>Mobile</h3>
                                <p>${ p.mobile }</p>
                            </section>
                        </div>
                    </div>
                </li>
                <li class="timeline-event">
                    <div class="timeline-event-icon bg-info">
                        <i class="fa fa-address-book"></i>
                    </div>
                    <div class="timeline-event-block block">
                        <div class="block-header">
                            <h3 class="block-title">Physical Address</h3>
                            <div class="block-options">
                                <div class="timeline-event-time block-options-item fs-sm">
                                    <i class="fa fa-info" title="user information"></i>
                                </div>
                            </div>
                        </div>
                        <div style = 'display : flex;flex-direction : row;'>
                            <section style = 'text-align:center;'>
                                <i class="fa-solid fa-user" id = 'fas_update'></i>
                                <h3 class = 'h3_update'>Citizen</h3>
                                <input type = 'text' loop = '1' field = 'citizen' value = '${ p.citizen }' placeholder = 'Add Input Field' id = 'update_student' style = 'border-radius:3px;min-height:40px;border:2px solid rgba(234,234,234,0.5);text-align:center;${ (p.citizen) ? '' : 'box-shadow:0px 2px 7px #ff6666;' }'>
                                <p id = 'update_feedback1'></p>
                            </section>   
                            <section style = 'text-align:center;'>
                                <i class="fa-solid fa-globe"  id = 'fas_update'></i>
                                <h3 class = 'h3_update'>County</h3>
                                <input type = 'text' loop = '2' field = 'county' value = '${ p.county }' placeholder = 'Add Input Field' id = 'update_student' style = 'border-radius:3px;min-height:40px;border:2px solid rgba(234,234,234,0.5);text-align:center;${ (p.county) ? '' : 'box-shadow:0px 2px 7px #ff6666;' }'>
                                <p id = 'update_feedback2'></p>
                            </section>     
                            <section style = 'text-align:center;'>
                                <i class="fa-solid fa-globe" id = 'fas_update'></i>
                                <h3 class = 'h3_update'>Sub-County</h3>
                                <input type = 'text' loop = '3' field = 'sub_county' value = '${ p.sub_county }' placeholder = 'Add Input Field' id = 'update_student' style = 'border-radius:3px;min-height:40px;border:2px solid rgba(234,234,234,0.5);text-align:center;${ (p.sub_county) ? '' : 'box-shadow:0px 2px 7px #ff6666;' }'>
                                <p id = 'update_feedback3'></p>
                            </section>
                        </div>
                    </div>
                </li>
                <li class="timeline-event">
                    <div class="timeline-event-icon bg-info">
                        <i class="fa fa-address-book"></i>
                    </div>
                    <div class="timeline-event-block block">
                        <div class="block-header">
                            <h3 class="block-title">Physical Address</h3>
                            <div class="block-options">
                                <div class="timeline-event-time block-options-item fs-sm">
                                    <i class="fa fa-info" title="user information"></i>
                                </div>
                            </div>
                        </div>
                        <div style = 'display : flex;flex-direction : row;'>        
                            <section style = 'text-align:center;'>
                                <i class="fa-solid fa-tower-broadcast" id = 'fas_update'></i>
                                <h3 class = 'h3_update'>Town</h3>
                                <input type = 'text' loop = '4' field = 'town' value = '${ p.town }' placeholder = 'Add Input Field' id = 'update_student'  style = 'border-radius:3px;min-height:40px;border:2px solid rgba(234,234,234,0.5);text-align:center;${ (p.town) ? '' : 'box-shadow:0px 2px 7px #ff6666;' }'>
                                <p id = 'update_feedback4'></p>
                            </section>        
                            <section style = 'text-align:center;'>
                                <i class="fa-solid fa-map-pin" id = 'fas_update'></i>
                                <h3 class = 'h3_update'>Address</h3>
                                <input type = 'text' loop = '5' field = 'address' value = '${ p.address }' placeholder = 'Add Input Field' id = 'update_student' style = 'border-radius:3px;min-height:40px;border:2px solid rgba(234,234,234,0.5);text-align:center;${ (p.address) ? '' : 'box-shadow:0px 2px 7px #ff6666;' }'>
                                <p id = 'update_feedback5'></p>
                            </section>        
                            <section style = 'text-align:center;'>
                                <i class="fa-solid fa-map-pin" id = 'fas_update'></i>
                                <h3 class = 'h3_update'>Postal Code</h3>
                                <input type = 'text' loop = '6' field = 'postal_code' value = '${ p.postal_code }' placeholder = 'Add Input Field' id = 'update_student' style = 'border-radius:3px;min-height:40px;border:2px solid rgba(234,234,234,0.5);text-align:center;${ (p.postal_code) ? '' : 'box-shadow:0px 2px 7px #ff6666;' }'>
                                <p id = 'update_feedback6'></p>
                            </section>  
                        </div>
                    </div>
                </li>
            </ul>      
        `)
        $('#student_profile').html(profile_string)
        if(profile_data.user[0].profile)
            document.getElementById('profile-set-image').src = profile_data.profile

        allowAccess()
    }
    const allowAccess = async(e) => {
        let collect = await ServerData.bindAuth('GET',`./checkProfile`,false)
        if(!collect)
            collect = await ServerData.bindAuth('GET',document.location.href + `/checkProfile`,false)

        /*
        let nav = await ServerData.bindAuth('GET',`./bindNav`,false)

        if(!nav)
            nav = await ServerData.bindAuth('GET',document.location.href + `/bindNav`,false)

         */

        console.log(collect)
        if(collect.user) {
            $('#in_course').css('display', 'block')
            $('#remind_profile').html("")
        }else {
            $('#allow_student').html('')
            $('#remind_profile').html("<p class = 'btn btn-sm btn-alt-danger'>Please complete your profile update</p>")
            $('#in_course').css('display','none')
        }
    }
    const plotName = async(e) => {
        let user_data = await ServerData.bindAuth('GET',`./checkName`,false)
        if(!user_data)
            user_data = await ServerData.bindAuth('GET', document.location.href + `/checkName`,false)
        $('#plot-user').html(user_data.name)
    }
    const buildGraph = async(e) => {
        let graph_data = await ServerData.bindAuth('GET',`./graph`,false)
        console.log(graph_data)
        let plot = [
            { 'go_id' : 'pie-cod','go_text' : 'Approved & Rejected Applications', 'type' : 'pie' },
            { 'go_id' : 'bar-cod','go_text' : 'Approved & Rejected Applications Over Intakes', 'type' : 'bar' }
        ]
        plot.map( p => {
            const { go_id, go_text, type } = p
            ServerData.createGraph({'graph_data' : graph_data.graph, 'id' : go_id, 'text' : go_text, 'label_one' : go_text, 'label_two' : go_text, 'label_three' : go_text, 'type' : type })
        })
    }

    $(document).ready(async function (qualifiedName, value){
        const notch = await ServerData.UPSTREAM()
        ServerData.DOWNSTREAM = notch.nut;
        ServerData.PATH = notch.route;
        ServerData.PICS = notch.imgs;
        $(document).on('click',ServerData.DOWNSTREAM.tag[0],async(e) => {
            e.preventDefault()

            ServerData.popUp({ 'msg' : '<p>' + e.currentTarget.attributes[4].value + '</p>', 'img' : 2, 'func' : ServerData.DOWNSTREAM.string[0], 'dump' : [] })
        })
        $(document).on('click',ServerData.DOWNSTREAM.tag[38],async(e) => {
            e.preventDefault()

            $('#fill-modal').remove()
            const element = document.getElementById("fill-modal");
            if(element)
                element.remove();

            let bindArray = []
            let attatched_a = []
            let attatched_c = []
            let attatched_ca = []

            document.querySelectorAll('#course_id').forEach( (v,k) => {
                if(v.checked){
                    document.querySelectorAll(ServerData.DOWNSTREAM.nodeID[0] + '' + v.value).forEach( a => {
                        if(a.checked) {
                            attatched_a.push(a.value)
                            attatched_c.push(a.attributes[3].value)
                        }
                    })
                    document.querySelectorAll(ServerData.DOWNSTREAM.nodeID[1] + '' + v.value).forEach( a => {
                        if(a.checked)
                            attatched_ca.push(a.value)
                    })
                    bindArray.push({ 'course' : v.value, 'intake' : v.attributes[2].value, 'course_code' : v.attributes[3].value, 'attendance' : attatched_a, 'attendance_code' : attatched_c, 'campus' : attatched_ca })
                }
            })
            let collect = await ServerData.bindAuth('POST', `${ ServerData.PATH[0] }`, true, {
                'value' : bindArray
            })
            console.log(collect)
            if(collect)
                ServerData.modalMsg({'msg': '<h3>Success!!</h3>', 'mode': true })
            else
                ServerData.modalMsg({'msg': '<h3>Error. Try again!!</h3>', 'mode': false })

        })
        $(document).on('click',ServerData.DOWNSTREAM.tag[1],async(e) => {
            e.preventDefault()
            let collect = await ServerData.bindAuth('GET',`./checkProfile`,false)
            if(!collect)
                collect = await ServerData.bindAuth('GET',document.location.href + `/checkProfile`,false)
            if(collect.user)
                document.location.assign(e.currentTarget.attributes[1].value)
            else
                ServerData.modalMsg({'msg': '<h3>Please complete your profile!!</h3>', 'mode': false })
        })
        $(document).on('click',ServerData.DOWNSTREAM.tag[2],(e) => {
            e.preventDefault()
            $('#input-profile').click()
        })
        $(document).on('change',ServerData.DOWNSTREAM.tag[3],async(e) => {
            const img = document.getElementById('input-profile').files[0]
            const frmD = new FormData();
            frmD.append('image',img)

            let update_pro = await ServerData.bindAuth('POST', './updateImg', false, frmD, true )
            if(!update_pro)
                update_pro = await ServerData.bindAuth('POST',document.location.href + '/updateImg',false, frmD, true)
            if(update_pro.feedback) {
                ServerData.modalMsg({'msg': '<h3>Uploaded!!</h3>', 'mode': true})
                document.getElementById('profile-set-image').src = 'Images/' + update_pro.feedback
            }else
                ServerData.modalMsg({'msg': `${ update_pro.errors.image.map( e => `<h3>${ e }</h3>` ).join('') }`, 'mode' : false })
        })
        $(document).on('keyup',ServerData.DOWNSTREAM.tag[4],async(e) => {
            let val = e.currentTarget.value
            let loop = e.currentTarget.attributes[1].value
            let field = e.currentTarget.attributes[2].value

            console.log(val)
            let collect = await ServerData.bindAuth('POST', `./updateProfile`, true, {
                'value' : val,
                'key' : field
            })
            if(!collect) {
                collect = await ServerData.bindAuth('POST', document.location.href + `/updateProfile`, true, {
                    'value': val,
                    'key': field
                })
            }
            console.log(collect)
            if(collect.feedback)
                $('#update_feedback' + loop).html('')

            allowAccess()
        })
        $(document).on('keydown',ServerData.DOWNSTREAM.tag[5],async(e) => {
            let loop = e.currentTarget.attributes[1].value
            $('#update_feedback' + loop).html('Editing...')
        })
        $(document).on('click',ServerData.DOWNSTREAM.tag[6],async(e) => {
            const cutOff = $('#cut_off_value').val()
            const courseId = $('#cut_off_approve').val().split(',')[0]

            if(cutOff && courseId) {
                let collect = await ServerData.bindAuth('POST', `./selectCourses`, true, {
                    'selected': courseId,
                    'cut_off': cutOff
                })
                if (!collect.feedback.includes(false)) {
                    ServerData.modalMsg({'msg': '<h3>Please Wait For Processing!!</h3>', 'mode': true})
                    document.location.assign('./change_course')
                } else
                    ServerData.modalMsg({'msg': '<h3>Error accessing record. Try again</h3>', 'mode': false})
            }else{
                if(!cutOff)
                    ServerData.modalMsg({'msg': '<h3>Cut Off Points required</h3>', 'mode': false})
                if(!courseId)
                    ServerData.modalMsg({'msg': '<h3>Course required</h3>', 'mode': false})
            }
        });
        $(document).on('click',ServerData.DOWNSTREAM.tag[7],async(e) => {
            e.preventDefault();
            if(e.currentTarget.attributes[2].value === 'false'){
                $('#session-add' + e.currentTarget.attributes[1].value).slideDown()
                e.currentTarget.attributes[2].value = true
                e.currentTarget.innerHTML = "VIEW LESS"
            }else{
                $('#session-add' + e.currentTarget.attributes[1].value).slideUp()
                e.currentTarget.attributes[2].value = false
                e.currentTarget.innerHTML = "VIEW SESSIONS"
            }
        });
        $(document).on('keyup',ServerData.DOWNSTREAM.tag[8],async(e) => {
            e.preventDefault();
            const index = e.currentTarget.attributes[1].value
            if(e.currentTarget.value)
                $(index).slideDown('slow')
            else
                $(index).slideUp('slow')
        });
        /*
        $(document).on('keyup','#cut_off_value',async(e) => {
            e.preventDefault()
            let cut_value = $('#cut_off_value').val()
            let allowed_courses = await ServerData.bindAuth('POST',`./platform_courses`,true,{ 'course' : cut_value })

            if(allowed_courses) {
                if (allowed_courses.group.length > 0) {
                    let allowed_courses_string = `
                <section style = 'width : 100%;display : flex;flex-wrap:wrap;background:#fff;'>
                    <div style = 'border:1px solid #ccc;width : 15.6%;margin : 0.2%;'>
                        <span>COURSE NAME</span>
                    </div>
                    <div style = 'border:1px solid #ccc;width : 15.6%;margin : 0.2%;'>
                        <span>COURSE CODE</span>
                    </div>
                    <div style = 'border:1px solid #ccc;width : 15.6%;margin : 0.2%;'>
                        <span>COURSE DURATION</span>
                    </div>
                    <div style = 'border:1px solid #ccc;width : 15.6%;margin : 0.2%;'>
                        <span>COURSE REQUIREMENTS</span>
                    </div>
                    <div style = 'border:1px solid #ccc;width : 15.6%;margin : 0.2%;'>
                        <span>CUT OFF POINTS</span>
                    </div>
                </section>
            `
                    allowed_courses_string += allowed_courses.group.map((c, k) =>
                        `
                    <section style = 'background:${(k % 2) ? '#fff' : 'rgba(234,234,234,0.7)'}width : 100%;display : flex;flex-wrap:wrap;'>
                        <div style = 'width : 15.6%;margin : 0.2%;border:${(k % 2) ? '1px solid rgba(234,234,234,0.7)' : '1px solid #fff'}'>
                            ${c.course_name}
                        </div>
                        <div style = 'width : 15.6%;margin : 0.2%;border:${(k % 2) ? '1px solid rgba(234,234,234,0.7)' : '1px solid #fff'}'>
                            ${c.course_code}
                        </div>
                        <div style = 'width : 15.6%;margin : 0.2%;border:${(k % 2) ? '1px solid rgba(234,234,234,0.7)' : '1px solid #fff'}'>
                            ${c.course_duration}
                        </div>
                        <div style = 'width : 15.6%;margin : 0.2%;border:${(k % 2) ? '1px solid rgba(234,234,234,0.7)' : '1px solid #fff'}'>
                            ${c.course_requirements}
                        </div>
                        <div style = 'width : 15.6%;margin : 0.2%;border:${(k % 2) ? '1px solid rgba(234,234,234,0.7)' : '1px solid #fff'}'>
                            ${c.cut_off}
                        </div>
                        <div style = 'width : 15.6%;margin : 0.2%;border:${(k % 2) ? '1px solid rgba(234,234,234,0.7)' : '1px solid #fff'}'>
                            <button id = 'select_course' index = '${c.id}' class = 'btn btn-alt-info'  data-toggle = 'click-ripple'>Select</button>
                        </div>
                    </section>
                `
                    )
                    $('#cut_off_courses').html(allowed_courses_string)
                }
            }else
                ServerData.modalMsg({ 'msg' : '<h3>Your already have a pending application</h3>', 'mode' : false })
        });


        $(document).on('click','#select_course',async(e) => {
            e.preventDefault()
            const select_course = e.currentTarget.attributes[1].value
            let collect = await ServerData.bindAuth('POST',`./selectCourses`,true,{ 'selected' : select_course })
            if(collect){
                ServerData.modalMsg({ 'msg' : '<h3>Changed!!</h3>', 'mode' : true })
                document.location.assign('./change_course')
            }else
                ServerData.modalMsg({ 'msg' : '<h3>Error accessing record. Try again</h3>', 'mode' : false })
        });

         */
        $(document).on('click',ServerData.DOWNSTREAM.tag[9],async(e) => {
            e.preventDefault()
            const intake = $('#all_intake').val().split(',')[0]
            let collect = await ServerData.bindAuth('POST',`./getCourses`,true,{ intake })
            let courses = collect.course.map( b => (!b.courses[0].status) ? Number(b.courses[0].id) : 0 );
            console.log(courses)
            let added = await ServerData.bindAuth('POST',`./addCourses`,true,{ intake, courses })
            if(!added.feedback.includes(0)){
                ServerData.modalMsg({ 'msg' : '<h3>Added All!!</h3>', 'mode' : true })
                plotCourses()
            }else
                ServerData.modalMsg({ 'msg' : '<h3>Not all records were added</h3>', 'mode' : false })

        })
        $(document).on('click',ServerData.DOWNSTREAM.tag[10],async(e) => {
            e.preventDefault()
            const course = $('#all_course').val().split(',')[0]
            const course_name = $('#all_course').val().split(',')[1]
            let collect = await ServerData.bindAuth('POST',`./getReport`,true,{ course })
            if(!collect.report.includes(false)) {
                if(collect.report.length > 0) {
                    const invoice = document.createElement('div')
                    invoice.setAttribute('id', 'print_pdf')
                    invoice.setAttribute('style', 'width:98%;margin:1%;height:98%;')
                    invoice.innerHTML = `
                    <div style = 'width:100%;text-align:center;'>
                        <img src = './../Images/clientlogo.png'>
                        <p style = 'font-size:180%'>REPORT ON CLASSES FOR THE COURSE ${ course_name }</p>
                        <p style = 'font-size:160%;background:rgba(234,234,234,0.7);height:40px;width:60%;'>DEPARTMENT : ${ collect.department }</p>
                    </div>
                    ${
                        collect.report.map(c =>
                        `
                        <section style = 'font-size:130%;width:100%;text-align:center;border:1px solid #ccc;margin-top:4%;'>
                            <p>Class : ${ c.class }</p>
                            <div style = 'width:100%;text-align:center;'>
                                <section style = 'width : 100%;display : flex;flex-wrap : wrap;'>
                                    <div style = 'width : 15%;margin : 0.5%;min-height : 20%;border : 1px solid #ccc;border-radius : 3px;'>
                                        INTAKE
                                    </div>
                                    <div style = 'width : 15%;margin : 0.5%;min-height : 20%;border : 1px solid #ccc;border-radius : 3px;'>
                                        FROM
                                    </div>
                                    <div style = 'width : 15%;margin : 0.5%;min-height : 20%;border : 1px solid #ccc;border-radius : 3px;'>
                                        TO
                                    </div>
                                    <div style = 'width : 15%;margin : 0.5%;min-height : 20%;border : 1px solid #ccc;border-radius : 3px;'>
                                        SEMESTER
                                    </div>
                                    <div style = 'width : 15%;margin : 0.5%;min-height : 20%;border : 1px solid #ccc;border-radius : 3px;'>
                                        YEAR
                                    </div>
                                </section>
                            </div>
                            <div style = 'width:100%;text-align:center;'>
                            ${
                                    c.intake.map((i, k) =>
                                        `
                                        <section style = 'width : 100%;display : flex;flex-wrap : wrap;${ (k%2) ? 'background::#fff':'background:rgba(234,234,234,0.7)' }'>
                                             <p style = 'width : 15%;margin : 0.5%;min-height : 20%;border-radius : 3px;${ (k%2) ? 'border : 1px solid #ccc;' : 'border : 1px solid #fff;'}'>${ i }</p>
                                             <p style = 'width : 15%;margin : 0.5%;min-height : 20%;border-radius : 3px;${ (k%2) ? 'border : 1px solid #ccc;' : 'border : 1px solid #fff;'}'>${ c.intakes_from[k] }</p>
                                             <p style = 'width : 15%;margin : 0.5%;min-height : 20%;border-radius : 3px;${ (k%2) ? 'border : 1px solid #ccc;' : 'border : 1px solid #fff;'}'>${ c.intakes_to[k] }</p>
                                             <p style = 'width : 15%;margin : 0.5%;min-height : 20%;border-radius : 3px;${ (k%2) ? 'border : 1px solid #ccc;' : 'border : 1px solid #fff;'}'>${ c.semester[k] }</p>
                                             <p style = 'width : 15%;margin : 0.5%;min-height : 20%;border-radius : 3px;${ (k%2) ? 'border : 1px solid #ccc;' : 'border : 1px solid #fff;'}'>${ c.year[k] }</p>
                                        </section>
                                        <section style = 'width : 100%;display : flex;flex-wrap : wrap;${ (k%2) ? 'background::#fff':'background:rgba(234,234,234,0.7)' }'>
                                            ${
                                            c.status[k].map( s => `<div class = '${ (s == "IN SESSION")? 'btn btn-sm btn-alt-success' : (s == "ONLINE SESSION") ? 'btn btn-sm btn-alt-success' :  (s == "WORKSHOP") ? 'btn btn-sm btn-alt-success' : 'btn btn-sm btn-alt-danger'}' style = 'margin:1%;'>${ s }</div>`).join('')
                                        }
                                        </section>
                                    `
                                    ).join('')
                                }
                            </div>
                        </section>
                        
                    `                            
                        )
                    }
                    `
                    ServerData.generatePDF({ 'body' : invoice, 'file' : 'DepartmentClasses.pdf' })
                }else
                    ServerData.modalMsg({ 'msg' : '<h3>There are no records</h3>', 'mode' : false })
            }else
                ServerData.modalMsg({ 'msg' : '<h3>There is no active intakes</h3>', 'mode' : false })
        })
        $(document).on('click',ServerData.DOWNSTREAM.tag[11],async(e) => {
            e.preventDefault()
            const intake = $('#all_intake').val().split(',')[0]
            const intake_name = $('#all_intake').val().split(',')[1]

            let collect = await ServerData.bindAuth('POST',`./getCourses`,true,{ intake })
            if(collect.course.length > 0) {
                const invoice = document.createElement('div')
                invoice.setAttribute('id', 'print_pdf')
                invoice.setAttribute('style', 'width:98%;margin:1%;height:98%;')
                invoice.innerHTML = `
                <div style = 'width:100%;text-align:center;'>
                    <img src = './../Images/clientlogo.png'>
                    <p style = 'font-size:180%'>REPORT ON COURSES FOR THE INTAKE ${ intake_name }</p>
                    <p style = 'font-size:160%;background:rgba(234,234,234,0.7);height:40px;width:60%;'>DEPARTMENT : ${ collect.department }</p>
                </div>
                <section style = 'width : 100%;display : flex;flex-wrap:wrap;'>
                    <div style = 'border:1px solid #ccc;width : 19.6%;margin : 0.2%;'>
                        <span>COURSE NAME</span>
                    </div>
                    <div style = 'border:1px solid #ccc;width : 19.6%;margin : 0.2%;'>
                        <span>COURSE CODE</span>
                    </div>
                </section>
                    ${
                        collect.course.map((c, key) =>
                            `
                            <section style = 'width: 98%;margin: 1%;display: flex;flex-wrap: wrap;flex-direction: row;border-radius: 3px;text-align: center;${(key % 2) ? 'background:#fff;border:1px solid #ccc' : 'background:rgba(234,234,234,0.7)'}'>
                                <div  style = 'width : 100%;display : flex;flex-wrap:wrap;'>
                                    <div style = 'border:1px solid #ccc;width : 19.6%;margin : 0.2%;'>                           
                                        <p>${c.courses[0].name}</p>
                                    </div>
                                    <div style = 'border:1px solid #ccc;width : 19.6%;margin : 0.2%;'>                            
                                        <p>${c.courses[0].code}</p> 
                                    </div> 
                                </div>
                                <div style = 'width : 100%;'>
                                    <p>Attendances allowed in intake</p>
                                    <div style = 'display : flex;flex-wrap : wrap;width: 100%;text-align:left;'>
                                    ${
                                        (c.attendances.length > 0)
                                            ?
                                            `
                                                            ${
                                                c.attendances.map(a =>
                                                    `
                                                        <button style = 'height:50px;${(a.status) ? 'background : #097B3E;border : 1px solid #fff;color : #fff;' : 'background : #fff;border : 1px solid rgba(0,0,0,0.7);color : rgb(0,0,0,0.7);'}'>
                                                            <i class='fas fa-users' style = 'font-size:350%;'></i>
                                                            <p>${a.name}</p>
                                                            <p>${a.code}</p>
                                                        </button>                                
                                                    `
                                                ).join('')
                                            }
                                                            `
                                            :
                                            `There are no attendances for this course`
                                    }
                                    </div>
                                </div>
                                
                                <div style = 'width : 100%;text-align:left;'>
                                    <p>Please select years allowed for the intake</p>
                                    <div style = 'display : flex;flex-wrap : wrap;width: 100%;'>
                                        ${
                                            (c.years.length > 0)
                                                ?
                                                `
                                                    ${
                                                        c.years.map(y =>
                                                            `
                                                                <button style = '${(!y.status) ? 'background : #fff;border : 1px solid rgba(0,0,0,0.7);color : rgb(0,0,0,0.7);' : 'background : #097B3E;border : 1px solid #fff;color : #fff;'}'>
                                                                    <p>Year ${y.name}</p>
                                                                </button>                               
                                                            `
                                                        ).join('')
                                                    }
                                                        `
                                                :
                                                `There are no years selected for this course`
                                        }
                                    </div>                    
                                </div>    
                            </section>
                            `
                        ).join('')
                    }
                `
                ServerData.generatePDF({ 'body' : invoice, 'file' : 'DepartmentIntake.pdf' })
            }else
                ServerData.modalMsg({ 'msg' : '<h3>There are no courses for the intake selected</h3>', 'mode' : false })

        });
        $(document).on('click',ServerData.DOWNSTREAM.tag[12],async(e) => {
            e.preventDefault()
            const intake = $('#all_intake').val().split(',')[0]
            let collect = await ServerData.bindAuth('POST',`./getCourses`,true,{ intake })
            let courses = collect.course.map( b => (b.courses[0].status) ? Number(b.courses[0].id) : 0 );
            console.log(courses)
            let removed = await ServerData.bindAuth('POST',`./removeCourses`,true,{ intake, courses })
            if(!removed.feedback.includes(0)){
                ServerData.modalMsg({ 'msg' : 'Removed All!!', 'mode' : true })
                plotCourses()
            }else
                ServerData.modalMsg({ 'msg' : 'There was an error. Try again', 'mode' : false })
        })
        $(document).on('click',ServerData.DOWNSTREAM.tag[13],async(e) => {
            e.preventDefault()
            const intake = $('#all_intake').val().split(',')[0]
            const course = e.currentTarget.attributes[1].value

            let status = 'Added!!'
            if(e.currentTarget.attributes[2].value === "true")
                status = "Removed!!"

            let added = await ServerData.bindAuth('POST',`./addCourse`,true,{ intake, course })
            if(added.feedback)
                ServerData.modalMsg({ 'msg' : `${ status }`, 'mode' : true },plotCourses())
            else
                ServerData.modalMsg({ 'msg' : 'There was an error. Try again', 'mode' : false })

        })
        $(document).on('click',ServerData.DOWNSTREAM.tag[14],async(e) => {
            e.preventDefault();
            ServerData.modalMsg({ 'msg' : '<h3>Please select the course first</h3>', 'mode' : false })
        })
        $(document).on('click',ServerData.DOWNSTREAM.tag[15],async(e) => {
            e.preventDefault()
            const attendance = e.currentTarget.attributes[1].value
            const course = e.currentTarget.attributes[4].value
            const intake = $('#all_intake').val().split(',')[0]

            let status = 'Added!!'
            if(e.currentTarget.attributes[2].value === "true")
                status = "Removed!!"

            let added = await ServerData.bindAuth('POST',`./addAttendance`,true,{ attendance, course, intake })
            if(added.feedback){
                ServerData.modalMsg({ 'msg' : `${ status }`, 'mode' : true })
                plotCourses()
            }else
                ServerData.modalMsg({ 'msg' : '<h3>There was an error. Try again</h3>', 'mode' : false })
        })
        $(document).on('click',ServerData.DOWNSTREAM.tag[16],async(e) => {
            e.preventDefault()
            $('#fill-modal').remove()
            const element = document.getElementById("fill-modal");
                        if(element)
                            element.remove();
        })
        $(document).on('click',ServerData.DOWNSTREAM.tag[17],async(e) => {
            e.preventDefault()
            const year = e.currentTarget.attributes[1].value
            const course = e.currentTarget.attributes[2].value
            const intake = e.currentTarget.attributes[3].value

            const sessionArr = []
            const typeArr = []
            document.querySelectorAll('#session-activity').forEach( s => {
                if(s.checked) {
                    sessionArr.push(s.value)
                    typeArr.push(s.attributes[2].value)
                }
            })
            let allow = true;
            if(typeArr.includes("0") && typeArr.includes("1"))
                allow = false
            if(allow) {
                let added = await ServerData.bindAuth('POST', `./classSession`, true, {
                    course,
                    year,
                    intake,
                    'session': sessionArr
                })
                if (!added.feedback.includes(false))
                    ServerData.modalMsg({ 'msg' : `<h3>Updated</h3>`, 'mode' : true, 'callback' : plotClasses() })
                else
                    ServerData.modalMsg({ 'msg' : `<h3>There was an error. Try again</h3>`, 'mode' : false })
            }else
                ServerData.modalMsg({ 'msg' : `<h3>The two session types cannot be included together. Change one</h3>`, 'mode' : false })

        })
        $(document).on('click',ServerData.DOWNSTREAM.tag[18],async(e) => {
            e.preventDefault()
            const year = e.currentTarget.attributes[1].value
            const course = e.currentTarget.attributes[4].value
            const intake = $('#all_intake').val().split(',')[0]

            let status = 'Added!!'
            if(e.currentTarget.attributes[2].value === "true")
                status = "Removed!!"

            let added = await ServerData.bindAuth('POST',`./addYears`,true,{ intake, course, year })
            if(added.feedback){
                ServerData.modalMsg({ 'msg' : `${ status }`, 'mode' : true, 'callback' :  plotCourses() })

            }else
                ServerData.modalMsg({ 'msg' : 'There was an error. Try again', 'mode' : false })
        })
        $(document).on('click',ServerData.DOWNSTREAM.tag[19],async(e) => {
            e.preventDefault()
            const year = e.currentTarget.attributes[3].value
            const intake = e.currentTarget.attributes[2].value
            const course = e.currentTarget.attributes[4].value
            const status = e.currentTarget.attributes[1].value
            console.log({ year, intake, course, status })
            let remove = await ServerData.bindAuth('POST',`./removeSession`,true,{ intake, course, year, status })
            if(remove.feedback)
                ServerData.modalMsg({ 'msg' : `Removed!`, 'mode' : true, 'callback' :  plotClasses() })
            else
                ServerData.modalMsg({ 'msg' : 'There was an error. Try again', 'mode' : false })
        })
        $(document).on('click',ServerData.DOWNSTREAM.tag[20],async(e) => {
            e.preventDefault()
            const year = e.currentTarget.attributes[1].value
            const intake = e.currentTarget.attributes[2].value
            const course = $('#all_course').val().split(',')[0]

            $('.content-force').append(`
                <div id = 'fill-modal'>
                    <div id = 'inner-fill-modal-stamp'>
                        <p>Please select the type of session</p>
                        <div id = 'session-option'>
                            <p style = 'background:rgba(234,234,234,0.7);width:100%;height:30px;'><input type = 'checkbox' id = 'session-activity' index = '1' value = 'IN SESSION'> IN SESSION</p>
                            <p style = 'background:#fff;width:100%;height:30px;'><input type = 'checkbox' id = 'session-activity' index = '0' value = 'LONG HOLIDAY'> LONG HOLIDAY</p>
                            <p style = 'background:rgba(234,234,234,0.7);width:100%;height:30px;'><input type = 'checkbox' id = 'session-activity' index = '0' value = 'SHORT HOLIDAY'> SHORT HOLIDAY</p>
                            <p style = 'background:#fff;width:100%;height:30px;'><input type = 'checkbox' id = 'session-activity' index = '1' value = 'ONLINE SESSION'> ONLINE SESSION</p>
                            <p style = 'background:rgba(234,234,234,0.7);width:100%;height:30px;'><input type = 'checkbox' id = 'session-activity' index = '1' value = 'WORKSHOP'> WORKSHOP</p>
                        </div>
                        <div id = 'make-buttons-section'>
                            <button id="close-stamp" class = 'btn btn-sm btn-alt-danger' data-toggle = 'click-ripple'>Close</button>
                            <button id="save-stamp" data-year = '${ year }' data-course = '${ course }' data-intake = '${ intake }' class = 'btn btn-sm btn-alt-success' data-toggle = 'click-ripple'>Save</button>
                        </div>
                    </div>
                </div>
            `)

        })
        $(document).on('click',ServerData.DOWNSTREAM.tag[21],async(e) =>{
            e.preventDefault()
            let applications = await ServerData.bindAuth('POST',`./printApplications`,true,{ 'status' : e.currentTarget.attributes[1].value })
            const decision = e.currentTarget.attributes[1].value.split(',')
            let operation = 'PENDING'
            if(decision.includes(1) || decision.includes(6) || decision.includes(3) || decision.includes(5) || decision.includes(7))
                operation = 'APPROVED'
            if(decision.includes(2) || decision.includes(4) || decision.includes(8) || decision.includes(9) || decision.includes(10))
                operation = 'REJECTED'
            if(applications.application){
                if(applications.application.length > 0){

                    const invoice = document.createElement('div')
                    invoice.setAttribute('id', 'print_pdf')
                    invoice.setAttribute('style', 'width:98%;margin:1%;height:98%;')
                    invoice.innerHTML = `
                    <div style = 'width:100%;text-align:center;'>
                        <img src = './../Images/clientlogo.png'>
                        <p style = 'font-size:180%'>REPORT ON ${ operation} APPLICATION FOR THE INTAKE ${ e.currentTarget.attributes[2].value }</p>
                        <p style = 'font-size:160%;background:rgba(234,234,234,0.7);height:40px;width:60%;'>DEPARTMENT : ${ applications.department }</p>
                    </div>   
                    ${
                        applications.application.map(user =>
                            `
                            ${
                                user.map((a, k) =>
                                    `
                                        <section style="font-size:120%width:98%;display:flex;text-align:center;margin:1%;${(k%2) ? 'background:rgba(234,234,234,0.7)' : 'background:#fff'}">
                                            <div style = "width:23%;margin:1%;${ (k%2) ? 'border:1px solid #fff' : 'border:1px solid rgba(234,234,234,0.7)'}">
                                                <p>Name</p>
                                                ${a.fname + ' ' + a.sname}
                                            </div>  
                                            <div style = "width:23%;margin:1%;${ (k%2) ? 'border:1px solid #fff' : 'border:1px solid rgba(234,234,234,0.7)'}">
                                                <p>Telephone</p>
                                                ${a.mobile}
                                            </div>  
                                            <div style = "width:23%;margin:1%;${ (k%2) ? 'border:1px solid #fff' : 'border:1px solid rgba(234,234,234,0.7)'}">
                                                <p>Course</p>
                                                ${a.course}
                                            </div> 
                                            <div style = "width:23%;margin:1%;${ (k%2) ? 'border:1px solid #fff' : 'border:1px solid rgba(234,234,234,0.7)'}">
                                                ${(a.status == 0) ? `WAITING FOR COD ACTION` : (a.status == 1) ? `<p>COD APPROVED</p>` : (a.status == 2) ? `<p>COD REJECTED</p>` : (a.status == 3) ? `<p>COD APPROVED & Dean APPROVED</p>` : (a.status == 4) ? `<p>COD APPROVED & DEAN REJECTED</p>` : (a.status == 5) ? `<p>COD REJECTED & DEAN APPROVED</p>` : (a.status == 6) ? `COD PUSHED APPROVED APPLICATION TO DEAN` : (a.status == 7) ? `DEAN PUSHED APPROVED APPLICATION FOR MAIL` : (a.status == 8) ? `COD & DEAN HAS REJECTED` : (a.status == 9) ? `COD PUSHED REJECTED APPLICATION TO DEAN` : (a.status == 10) ? `DEAN PUSHED REJECTED APPLICATION TO MaIL` : 'APPLICANT HAS NOT FINISHED APPLYING'}
                                            </div>   
                                        </section>                                                                            
                                    `
                                )
                            }
                        `
                        )
                    }
                    `
                    ServerData.generatePDF({ 'body' : invoice, 'file' : `${ applications.department }${ operation }.pdf` })
                }else
                    ServerData.modalMsg({'msg' : '<h3>Could not find data</h3>', 'mode' : false})
            }else
                ServerData.modalMsg({'msg' : '<h3>Database Empty</h3>', 'mode' : false})
        })
        $(document).on('click',ServerData.DOWNSTREAM.tag[22],function(e){
            e.preventDefault()
            sessionStorage.setItem('appId',e.currentTarget.attributes[1].value)
            sessionStorage.setItem('programId',e.currentTarget.attributes[2].value)
            sessionStorage.setItem('status',e.currentTarget.attributes[3].value)
            sessionStorage.setItem('nameIntake',e.currentTarget.attributes[4].value)
            document.location.assign(`./pendingView`)
        })
        $(document).on('click',ServerData.DOWNSTREAM.tag[23],function(e){
            e.preventDefault();
            const level = Number(e.currentTarget.attributes[1].value);
            const prev = Number(level - 1)

            if(level > 1){
                document.getElementById('intake' + prev).style.display = "block"
                document.getElementById('intake' + level).style.display = "none"
            }
            if(level == 2)
                $('#current_session').css('display','none')
            if(level == 3)
                $('#current_session').css('display','block')

        })
        $(document).on('click',ServerData.DOWNSTREAM.tag[24], async(e) =>{
            e.preventDefault()
            const search = $('#search-input').val();
            let search_query = await ServerData.bindAuth('POST',`./getCandidate`,true,{ 'value' : search })
            console.log(search_query)
            let approvals = "<div id = 'time-out'><img src = './../Images/clipboard.svg'>Database Empty</div>"
            if(search_query.user){
                approvals = "<div id = 'time-out'><img src = './../Images/clipboard.svg'>Could not find data</div>"
                if(search_query.user.length > 0){
                    approvals = search_query.user.map( (a,k) =>
                        `
                            <section class = 'part-level' style = '${ (k%2)? 'background:#fff':'background:rgba(234,234,234,0.7)' }'>
                                <div>
                                    <p>Name</p>
                                    ${ a.fname + ' ' + a.sname }
                                </div>
                                <div>
                                    <p>Telephone</p>
                                    ${ a.mobile }
                                </div>
                                ${
                                    (search_query.application.length > 0)
                                    ?
                                    `
                                    ${
                                        (search_query.role == 2)
                                            ?
                                            `
                                        <div>
                                            ${(search_query.application[0][0].status == 0) ? `<button id = 'approve-button' index = '${a.id}' class = 'btn btn-sm btn-alt-success' data-toggle = 'click-ripple'>Approve</button>` : (search_query.application[0][0].status == 1) ? `<p>COD APPROVED</p>` : (search_query.application[0][0].status == 2) ? `<p>COD REJECTED</p>` : (search_query.application[0][0].status == 3) ? `<p>COD APPROVED & Dean APPROVED</p>` : (search_query.application[0][0].status == 4) ? `<p>COD APPROVED & DEAN REJECTED</p>` : (search_query.application[0][0].status == 5) ? `<p>COD REJECTED & DEAN APPROVED</p>` : (search_query.application[0][0].status == 6) ? `COD PUSHED APPROVED APPLICATION TO DEAN` : (search_query.application[0][0].status == 7) ? `DEAN PUSHED APPROVED APPLICATION FOR MAIL` : (search_query.application[0][0].status == 8) ? `COD & DEAN HAS REJECTED` : (search_query.application[0][0].status == 9) ? `COD PUSHED REJECTED APPLICATION TO DEAN` : (search_query.application[0][0].status == 10) ? `DEAN PUSHED REJECTED APPLICATION TO MaIL` : 'APPLICANT HAS NOT FINISHED APPLYING'}
                                        </div>
                                        <div>
                                            ${(search_query.application[0][0].status == 0) ? `<button id = 'reject-button' index = '${a.id}' class = 'btn btn-sm btn-alt-danger' data-toggle = 'click-ripple'>Reject</button>` : (search_query.application[0][0].status == 1) ? `<button id = 'reject-button' index = '${a.id}' class = 'btn btn-sm btn-alt-danger' data-toggle = 'click-ripple'>Reject</button>` : (search_query.application[0][0].status == 2) ? `<button id = 'approve-button' index = '${a.id}' class = 'btn btn-sm btn-alt-success' data-toggle = 'click-ripple'>Approve</button>` : (search_query.application[0][0].status == 3) ? `<p>COD APPROVED & DEAN APPROVED</p>` : (search_query.application[0][0].status == 4) ? `<p>COD APPROVED & DEAN REJECTED APPLICATION</p>` : (search_query.application[0][0].status == 5) ? `<p>COD REJECTED & DEAN APPROVED APPLICATION</p>` : (search_query.application[0][0].status == 6) ? `COD PUSHED APPROVED APPLICATION TO DEAN` : (search_query.application[0][0].status == 7) ? `DEAN PUSHED ACCEPTED APPLICATION FOR MAIL` : (search_query.application[0][0].status == 8) ? `COD & DEAN HAS REJECTED APPLICATION` : (search_query.application[0][0].status == 9) ? `COD PUSHED REJECTED APPLICATION TO DEAN` : (search_query.application[0][0].status == 10) ? `DEAN PUSHED REJECTED APPLICATION TO MAIL` : 'APPLICANT HAS NOT FINISHED APPLYING'}
                                        </div>
                                        `
                                            :
                                            `
                                        <div>
                                            ${(search_query.application[0][0].status == 0) ? `PENDING COD ACTION` : (search_query.application[0][0].status == 1) ? `<p>COD APPROVED</p>` : (search_query.application[0][0].status == 2) ? `<p>COD REJECTED</p>` : (search_query.application[0][0].status == 3) ? `<p>COD APPROVED & DEAN APPROVED</p>` : (search_query.application[0][0].status == 4) ? `<p>COD APPROVED & DEAN REJECTED</p>` : (search_query.application[0][0].status == 5) ? `<p>COD REJECTED & DEAN APPROVED</p>` : (search_query.application[0][0].status == 6) ? `<button id = 'approve-button' index = '${a.id}' class = 'btn btn-sm btn-alt-success' data-toggle = 'click-ripple'>Approve</button>` : (search_query.application[0][0].status == 7) ? `DEAN HAS PUSHED ACCEPTED APPLICATIONS` : (search_query.application[0][0].status == 8) ? `COD & DEAN HAS REJECTED` : (search_query.application[0][0].status == 9) ? `<button id = 'approve-button' index = '${a.id}' class = 'btn btn-sm btn-alt-success' data-toggle = 'click-ripple'>Approve</button>` : (search_query.application[0][0].status == 10) ? `DEAN PUSHED REJECTED APPLICATION` : 'APPLICANT HAS NOT FINISHED APPLYING'}
                                        </div>
                                        <div>
                                            ${(search_query.application[0][0].status == 0) ? `PENDING COD ACTION` : (search_query.application[0][0].status == 1) ? `<p>COD APPROVED</p>` : (search_query.application[0][0].status == 2) ? `<p>COD REJECTED</p>` : (search_query.application[0][0].status == 3) ? `<p>COD APPROVED & DEAN APPROVED</p>` : (search_query.application[0][0].status == 4) ? `<p>COD APPROVED & DEAN REJECTED</p>` : (search_query.application[0][0].status == 5) ? `<p>COD REJECTED & DEAN APPROVED</p>` : (search_query.application[0][0].status == 6) ? `<button id = 'reject-button' index = '${a.id}' class = 'btn btn-sm btn-alt-danger' data-toggle = 'click-ripple'>Reject</button>` : (search_query.application[0][0].status == 7) ? `DEAN HAS PUSHED ACCEPTED APPLICATIONS` : (search_query.application[0][0].status == 8) ? `COD & DEAN HAS REJECTED` : (search_query.application[0][0].status == 9) ? `<button id = 'reject-button' index = '${a.id}' class = 'btn btn-sm btn-alt-danger' data-toggle = 'click-ripple'>Reject</button>` : (search_query.application[0][0].status == 10) ? `DEAN PUSHED REJECTED APPLICATION` : 'APPLICANT HAS NOT FINISHED APPLYING'}
                                        </div>
                                        `
                                    }
                                    `
                                    :
                                    'NO APPLICATION'
                                }
                                <div>
                                    <button id = 'view-more-level' pin = 'false' key = '${ k }' class = 'btn btn-alt-info' data-toggle = 'click-ripple'>View More</button>
                                </div>
                            </section>
                            <section class = 'inner-part-level${ k }' id = 'inner-part-level' style = 'display:none;'>
                                <h3>Academics Profile</h3>
                                ${
                                    (search_query.education.length > 0)
                                    ?
                                    `
                                        <div id = 'other-table'>
                                            <div>
                                                <p>Institution</p>
                                                ${ search_query.education[0].institution }
                                            </div>
                                            <div>
                                                <p>Grade</p>
                                                ${ search_query.education[0].qualification }
                                            </div>
                                            <div>
                                                <p>Certificate</p>
                                                <a href = './../certs/${ search_query.education[0].certificate }' target = '_blank' class = 'btn btn-sm btn-alt-success'>Download</a>
                                            </div>
                                        </div>                              
                                    `
                                :
                                `Applicant has no academic profile`
                                } 
                                <h3>Work Profile</h3>
                                ${
                                    (search_query.work.length > 0)
                                    ?
                                    `
                                         <div id = 'other-table'>
                                            <div>
                                                <p>Institution</p>
                                                ${search_query.work[0].organization}
                                            </div>
                                            <div>
                                                <p>Job</p>
                                                ${search_query.work[0].post}
                                            </div>
                                        </div>                                   
                                    `
                                    :
                                    `Applicant has no work profile`
                                }
                                <h3>Application Process</h3>
                                <div id = 'other-table'>
                                    ${
                                        (search_query.application.length > 0)
                                        ?
                                        `
                                        ${
                                            (search_query.application[0][0].process_status) ? $.parseJSON(search_query.application[0][0].process_status).map((s, k) =>
                                                `
                                            <section style = '${ (k%2) ? 'background:rgba(234,234,234,0.7)' : 'background:#fff'}'>
                                                <div id = 'number' style = '${ (k%2) ? 'border: 1px solid #fff' : 'border:1px solid rgba(@34,234,234,0.7)'}'>
                                                    ${(k + 1)}
                                                </div>
                                                <div style = '${ (k%2) ? 'border: 1px solid #fff' : 'border:1px solid rgba(@34,234,234,0.7)'}'>
                                                    <p>Action</p>
                                                    ${(s.status == 1) ? `COD APPROVED` : (s.status == 2) ? `COD REJECTED` : (s.status == 3) ? `COD APPROVED & DEAN APPROVED` : (s.status == 4) ? `COD APPROVED & DEAN REJECTED` : (s.status == 5) ? `COD REJECTED & DEAN APPROVED` : (s.status == 6) ? `COD HAS APPROVED & PUSHED TO DEAN` : (s.status == 7) ? `DEAN HAS APPROVED & PUSHED FOR MAIL` : (s.status == 8) ? `COD REJECTED && DEAN REJECTED` : (s.status == 9) ? `COD REJECTED && PUSHED TO DEAN` : (s.status == 10) ? `DEAN HAS REJECTED && PUSHED TO MAIL` : `STILL PENDING`}
                                                </div>
                                                <div style = '${ (k%2) ? 'border: 1px solid #fff' : 'border:1px solid rgba(@34,234,234,0.7)'}'>
                                                    <p>Reason</p>
                                                    ${s.reason}
                                                </div>
                                                <div style = '${ (k%2) ? 'border: 1px solid #fff' : 'border:1px solid rgba(@34,234,234,0.7)'}'>
                                                    <p>Designation</p>
                                                    ${s.level}
                                                </div>
                                                <div style = '${ (k%2) ? 'border: 1px solid #fff' : 'border:1px solid rgba(@34,234,234,0.7)'}'>
                                                    <p>Date</p>
                                                    ${s.date}
                                                </div>
                                            </section>
                                            `
                                            ).join('')
                                            : '<p>PENDING COD ACTION</p>'
                                        }
                                        `
                                        :
                                        `NO APPLICATION`
                                    }
                                </div>
                            </section>
                            `
                    )

                }
            }
            $('#candidate-page').html(approvals)
        })
        $(document).on('click',ServerData.DOWNSTREAM.tag[25],function(e){
            e.preventDefault();
            if(e.currentTarget.attributes[2].value === 'false'){
                $('.attendance-section' + e.currentTarget.attributes[1].value).slideDown()
                e.currentTarget.attributes[2].value = true
                e.currentTarget.innerHTML = "View Less"
            }else{
                $('.attendance-section' + e.currentTarget.attributes[1].value).slideUp()
                e.currentTarget.attributes[2].value = false
                e.currentTarget.innerHTML = "View Attendances"
            }
        })
        $(document).on('click',ServerData.DOWNSTREAM.tag[26],function(e){
            e.preventDefault();
            if(e.currentTarget.attributes[2].value === 'false'){
                $('.class-section' + e.currentTarget.attributes[1].value).slideDown()
                e.currentTarget.attributes[2].value = true
                e.currentTarget.innerHTML = "View Less"
            }else{
                $('.class-section' + e.currentTarget.attributes[1].value).slideUp()
                e.currentTarget.attributes[2].value = false
                e.currentTarget.innerHTML = "View Years"
            }
        })
        $(document).on('keyup',ServerData.DOWNSTREAM.tag[27],async(e) =>{
            e.preventDefault()
            const search = $('#courses-search').val()
            const intake = $('#all_intake').val().split(',')[0]
            console.log(intake)
            let collect = await ServerData.bindAuth('POST',`./searchCourses`,true,{ intake, search })
            console.log(collect)
            let plot_string = "No courses available for this department in the registrar database"
            if(collect.course.length > 0) {
                plot_string = `
                <section id = 'courses-section'>
                    <div style = 'border:1px solid #ccc'>
                        <span>COURSE NAME</span>
                    </div>
                    <div style = 'border:1px solid #ccc'>
                        <span>COURSE CODE</span>
                    </div>
                    <div style = 'border:1px solid #ccc'>
                        <span>ADD/REMOVE COURSE</span>
                    </div>
                    <div style = 'border:1px solid #ccc'>
                        <span>EDIT ATTENDANCE</span>
                    </div>
                    <div style = 'border:1px solid #ccc'>
                        <span>EDIT CLASS</span>
                    </div>
                </section>
            `
                plot_string += collect.course.map( (c,key) =>
                    `
                    <section style = '${(key%2) ? 'background:#fff' : 'background:rgba(234,234,234,0.7)' }'>
                        <div id = 'courses-section'>
                            <div>                           
                                <p>${ c.courses[0].name }</p>
                            </div>
                            <div>                            
                                <p>${ c.courses[0].code }</p> 
                            </div> 
                            <button id = 'confirm-box' index = '${c.courses[0].id}' status = '${c.courses[0].status}' class = '${(c.courses[0].status) ? 'btn btn-sm btn-alt-success' : 'btn btn-sm btn-alt-danger'}'>
                                 ${ (c.courses[0].status) ? 'Remove Course' : 'Select Course' }
                            </button> 
                            <button id = 'view-attendance' iteration = '${ key }' chosen = 'false' class = 'btn btn-sm btn-alt-primary'>View Attendance</button>                                              
                            <button id = 'view-class' iteration = '${ key }' chosen = 'false' class = 'btn btn-sm btn-alt-primary'>View Years</button>                                              
                        </div>
                        <div id = 'attendance-section' class = 'attendance-section${ key }'>
                            <p>Attendances allowed in intake</p>
                            <div = 'attendance-build'>
                            ${
                            (c.attendances.length > 0)
                                ?
                                `
                                    ${
                                    c.attendances.map(a =>
                                        `
                                                <button id = '${(c.courses[0].status) ? 'confirm-attendance-box' : 'attendant-button'}' index = '${ a.id }' status = '${ a.status }' class = '${(a.status) ? 'box-in' : 'box-out'}' course = '${ a.course }'>
                                                    <i class='fas fa-users' style = 'font-size:350%;'></i>
                                                    <p>${ a.name }</p>
                                                    <p>${ a.code }</p>
                                                </button>                                
                                            `
                                    ).join('')
                                }
                                    `
                                :
                                `There are no attendances for this course`
                        }
                            </div>
                        </div>
                        
                        <div id = 'years-section' class = 'class-section${ key }'>
                            <p>Please select years allowed for the intake</p>
                            <div id = 'attendance-build'>
                                ${
                            (c.years.length > 0)
                                ?
                                `
                                    ${
                                    c.years.map(y =>
                                        `
                                                <button id = '${ (c.courses[0].status) ? 'confirm-years-box' : 'attendant-button'}' index = '${ y.id }' status = '${ y.status }' class = '${(!y.status) ? 'box-out' : 'box-in'}' course = '${ y.course }'>
                                                    <p>Year ${ y.name }</p>
                                                </button>                               
                                            `
                                    ).join('')
                                }
                                    `
                                :
                                `There are no years selected for this course`
                        }
                            </div>                    
                        </div>    
                    </section>
                `
                ).join('')
                plot_string += '</div>'
            }

            $('#course-page').html(plot_string)
        })
        $(document).on('click',ServerData.DOWNSTREAM.tag[28],function(e){
            e.preventDefault();
            $('#fill-modal').remove();
            const element = document.getElementById("fill-modal");
            if(element)
                element.remove();
        })
        $(document).on('click',ServerData.DOWNSTREAM.tag[29],async function(e){
            e.preventDefault()
            var check = confirm("Are you sure you want to approve?");
            if(check){
                let application_approve = await ServerData.bindAuth('POST',`./approveApplication`,true,{ 'application' : e.currentTarget.attributes[1].value, 'reason' : 'OK' })
                if(application_approve.user){
                    ServerData.modalMsg({ 'msg' : `<h3>Success!!</h3>`, 'mode' : true })
                    ServerData.beApproved(ServerData.Page,0)
                }else
                    ServerData.modalMsg({ 'msg' : `<h3>There was an error. Try again</h3>`, 'mode' : false })

            }
        })
        $(document).on('click',ServerData.DOWNSTREAM.tag[30],async function(e){
            e.preventDefault()
            if(ServerData.records.length > 0){
                var check = confirm("Are you sure you want to approve all the records?");
                if(check){
                    let application_approve = await ServerData.bindAuth('POST',`./approveApplications`,true,{ 'application' : ServerData.records })
                    console.log(application_approve)
                    if(!application_approve.user.includes(false)){
                        ServerData.modalMsg({ 'msg' : `<h3>Success!!</h3>`, 'mode' : true })
                        ServerData.beApproved(ServerData.Page,0)
                    }else{
                        let recordKeys = []
                        application_approve.user.map((f,k) => {
                            if(f === "false")
                                recordKeys.push(k)
                        })
                        ServerData.modalMsg({ 'msg' : `${
                                recordKeys.map(v =>
                                    `<h3>There was an error with record ${ v }</h3>`
                                ).join('')
                            }`, 'mode' : false })
                    }
                }
            }else
                ServerData.modalMsg({ 'msg' : `<h3>There are no records</h3>`, 'mode' : false })

        })
        $(document).on('click',ServerData.DOWNSTREAM.tag[31],async function(e){
            e.preventDefault()
            let reason = $('#rejection-reason').val()
            if(reason){
                let application_reject = await ServerData.bindAuth('POST',`./rejectApplication`,true,{ 'application' : e.currentTarget.attributes[1].value, 'reason' : reason })
                if(application_reject.user){
                    $('#fill-modal').html(`
                        <div id = 'inner-fill-modal'>
                            <img src = './../Images/success-tick.gif'>
                            <h3>Success!!</h3>
                        </div>
                    `)
                    setTimeout(
                        function(){
                            $('#fill-modal').remove()
                            const element = document.getElementById("fill-modal");
                                                    if(element)
                            element.remove();
                            ServerData.beApproved(ServerData.Page,0)
                        }
                    ,2000)
                }else{
                    $('#fill-modal').html(`
                        <div id = 'inner-fill-modal'>
                            <img src = './../Images/error-tick.jpg'>
                            <h3>There was an error. Try again</h3>
                        </div>
                    `)
                    setTimeout(function(){
                        $('#fill-modal').remove()
                        const element = document.getElementById("fill-modal");
                                                if(element)
                            element.remove();
                        },2000)
                }
            }else
                ServerData.modalMsg({ 'msg' : `<h3>Give a reason</h3>`, 'mode' : false })

        })
        $(document).on('click',ServerData.DOWNSTREAM.tag[32],async function(e){
            var check = confirm("Are you sure you want to push?");
            if(check){
                let status = e.currentTarget.attributes[2].value
                let pushed = await ServerData.bindAuth('POST',`./push`,true,{ 'intake' : e.currentTarget.attributes[1].value, status  })
                console.log(pushed)
                if(pushed.now){
                    ServerData.modalMsg({ 'msg' : `<h3>Success!!</h3>`, 'mode' : true })
                    retrieveApplication(status)
                }else
                    ServerData.modalMsg({ 'msg' : `<h3>There was an error. Try again</h3>`, 'mode' : false })
            }
        })
        $(document).on('click',ServerData.DOWNSTREAM.tag[33],async function(e){
            e.preventDefault()
            var check = confirm("Are you sure you want to reject?");
            if(check){
                $('.content-force').append(`
                    <div id = 'fill-modal'>
                        <div id = 'inner-fill-modal'>
                            <img src = './../Images/question.gif'>
                            <p>Reason For Rejection</p>
                            <form accept-charset=utf8>
                                <textarea id = 'rejection-reason' class = 'message-area'></textarea>
                                <button id = 'confirm-reject' carry-id = '${ e.currentTarget.attributes[1].value }' type = 'submit' class = 'button-area' class = 'btn btn-alt-info' data-toggle = 'click-ripple'>Confirm</button>
                            </form>
                        </div>
                    </div>
                `)
            }

        })
        $(document).on('click',ServerData.DOWNSTREAM.tag[34],function(e){
            e.preventDefault()
            document.location.assign(e.currentTarget.attributes[0].value);
        })
        $(document).on('click',ServerData.DOWNSTREAM.tag[35],function(e){
            e.preventDefault();
            document.querySelectorAll('input').forEach( i => {
                i.value = ""
            })
            document.querySelectorAll('select').forEach( s => {
                s.value = ""
            })
            $('#intake1').fadeIn('slow');
            $('#intake4').fadeOut('slow');
        })
        $(document).on('click',ServerData.DOWNSTREAM.tag[36],function(e){
            e.preventDefault();
            if(e.currentTarget.attributes[1].value === 'false'){
                $('.inner-part-level' + e.currentTarget.attributes[2].value).slideDown()
                e.currentTarget.attributes[1].value = true
                e.currentTarget.innerHTML = "View Less"
            }else{
                $('.inner-part-level' + e.currentTarget.attributes[2].value).slideUp()
                e.currentTarget.attributes[1].value = false
                e.currentTarget.innerHTML = "View More"
            }
        })
        $(document).on('keyup',ServerData.DOWNSTREAM.tag[37],function(e){
            e.preventDefault();
            ServerData.plotLegend({ 'id' : e.currentTarget.attributes[1].value, 'value' : e.currentTarget.value })
        })

    })
