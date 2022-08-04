    const ServerData = new (function(){
        this.studies = ['Certificate','Diploma','Non-standard','Graduate','Post-Graduate','Under-Graduate','Masters','PHD'];
        this.attendance_arr = ['REGULAR','FULL-TIME','PART-TIME','ONLINE-LEARNING','HOLIDAY-LEARNING','DISTANCE-LEARNING','EVENING']
        this.bindAuth = async function(r, h, c, m){
            let pop = { method : r }
            if(r == "POST")
                pop.body = JSON.stringify(m)
            if(c)
                pop.headers = { 'Content-type': 'application/json; charset=UTF-8', 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
            try {
                const response = await fetch( h, pop );
                const tears = await response.json();
                return tears;

            } catch (error) {
                console.log(error);
            }
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
                    ServerData.beApproved(new_category,0)
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
        this.beApproved = async(page,filter) => {
            const attendance = $('#attendance_search').val().split(',')[0]
            const course = $('#course_search').val().split(',')[1]
            const year = $('#stage_search').val().split(',')[0]
            const status = (sessionStorage.getItem('status')) ? sessionStorage.getItem('status') : "0"
            const intake = (sessionStorage.getItem('appId')) ? sessionStorage.getItem('appId') : 1
            const level = (sessionStorage.getItem('programId')) ? sessionStorage.getItem('programId') : 1
            document.querySelectorAll('#search-button').forEach( (s,b) => {
                if(b == status){
                    s.style.background = '#1f2937'
                    s.style.color = '#fff'
                    s.style.border = '1px solid #fff'
                }else{
                    s.style.background = '#fff'
                    s.style.color = '#000'
                    s.style.border = '1px solid #1f2937'
                }
            })
            let limit = (100 * page)
            let offset = (limit - 100)
            console.log({ 'course' : course, 'level' : level, 'attendance' : attendance, 'year' : year, 'status' : status, 'intake' : intake, 'limit' : limit, 'offset' : offset })
            let applications = await this.bindAuth('POST',`approval/getApplications`,true,{ 'course' : course, 'level' : level, 'attendance' : attendance, 'year' : year, 'status' : status, 'intake' : intake, 'limit' : limit, 'offset' : offset, filter })
            console.log(applications)
            ServerData.Page = applications.page
            let pages = [];
            for(let x = 1;x <= ServerData.Page;x++)
                pages.push(x)

            ServerData.buildSelect({'id' : '#page_approve', 'placeholder' : 'Select Page', 'data' : pages })
            let approvals = 'Database Empty'
            if(applications.user){
                approvals = "<div id = 'time-out'><img src = './../Images/clipboard.svg'>Could not find data</div>"
                if(applications.user.length > 0){
                    approvals = applications.user.map((a,k) =>
                        `
                            <section class = 'part-level'>
                                <div>
                                    <p>Name</p>
                                    ${ a[0].fname + ' ' + a[0].sname }
                                </div>
                                <div>
                                    <p>Telephone</p>
                                    ${ a[0].telephone }
                                </div>
                                <div>
                                    <p>Fee</p>
                                    ${ a[0].amount }
                                </div>
                                ${
                                    (applications.role == 2)
                                    ?
                                    `
                                        <div>
                                            ${ (a[0].final_status == 0)? `<button id = 'approve-button' index = '${ a[0].applications_id }' class = 'btn btn-alt-success' data-toggle = 'click-ripple'>Approve</button>` : (a[0].final_status == 1) ? `<p>COD APPROVED</p>` : (a[0].final_status == 2) ? `<p>COD REJECTED</p>` : (a[0].final_status == 3) ? `<p>COD APPROVED & Dean APPROVED</p>` : (a[0].final_status == 4) ? `<p>COD APPROVED & DEAN REJECTED</p>` : (a[0].final_status == 5) ? `<p>COD REJECTED & DEAN APPROVED</p>` : (a[0].final_status == 6) ? `COD PUSHED APPROVED APPLICATION TO DEAN` : (a[0].final_status == 7) ? `DEAN PUSHED APPROVED APPLICATION FOR MAIL` : (a[0].final_status == 8) ? `COD & DEAN HAS REJECTED`   : (a[0].final_status == 9) ? `COD PUSHED REJECTED APPLICATION TO DEAN` : (a[0].final_status == 10) ? `DEAN PUSHED REJECTED APPLICATION TO MaIL`  : 'false'  }
                                        </div>
                                        <div>
                                            ${ (a[0].final_status == 0)? `<button id = 'reject-button' index = '${ a[0].applications_id }' class = 'btn btn-alt-warning' data-toggle = 'click-ripple'>Reject</button>` : (a[0].final_status == 1) ? `<button id = 'reject-button' index = '${ a[0].applications_id }' class = 'btn btn-alt-warning' data-toggle = 'click-ripple'>Reject</button>` : (a[0].final_status == 2) ? `<button id = 'approve-button' index = '${ a[0].applications_id }' class = 'btn btn-alt-success' data-toggle = 'click-ripple'>Approve</button>` : (a[0].final_status == 3) ? `<p>COD APPROVED & DEAN APPROVED</p>` : (a[0].final_status == 4) ? `<p>COD APPROVED & DEAN REJECTED APPLICATION</p>` : (a[0].final_status == 5) ? `<p>COD REJECTED & DEAN APPROVED APPLICATION</p>` : (a[0].final_status == 6) ? `COD PUSHED APPROVED APPLICATION TO DEAN`  : (a[0].final_status == 7) ? `DEAN PUSHED ACCEPTED APPLICATION FOR MAIL` : (a[0].final_status == 8) ? `COD & DEAN HAS REJECTED APPLICATION` : (a[0].final_status == 9) ? `COD PUSHED REJECTED APPLICATION TO DEAN` : (a[0].final_status == 10) ? `DEAN PUSHED REJECTED APPLICATION TO MAIL` : 'false'  }
                                        </div>
                                    `
                                    :
                                    `
                                        <div>
                                            ${  (a[0].final_status == 0)? `PENDING COD ACTION` : (a[0].final_status == 1) ? `<p>COD APPROVED</p>` : (a[0].final_status == 2) ? `<p>COD REJECTED</p>` : (a[0].final_status == 3) ? `<p>COD APPROVED & DEAN APPROVED</p>` : (a[0].final_status == 4) ? `<p>COD APPROVED & DEAN REJECTED</p>` : (a[0].final_status == 5) ? `<p>COD REJECTED & DEAN APPROVED</p>` : (a[0].final_status == 6) ? `<button id = 'approve-button' index = '${ a.applications_id }' class = 'btn btn-alt-success' data-toggle = 'click-ripple'>Approve</button>` : (a[0].final_status == 7) ? `DEAN HAS PUSHED ACCEPTED APPLICATIONS` : (a[0].final_status == 8) ? `COD & DEAN HAS REJECTED` : (a[0].final_status == 9) ? `<button id = 'approve-button' index = '${ a[0].applications_id }' class = 'btn btn-alt-success' data-toggle = 'click-ripple'>Approve</button>` : (a[0].final_status == 10) ? `DEAN PUSHED REJECTED APPLICATION` : 'false'  }
                                        </div>
                                        <div>
                                            ${  (a[0].final_status == 0)? `PENDING COD ACTION` : (a[0].final_status == 1) ? `<p>COD APPROVED</p>` : (a[0].final_status == 2) ? `<p>COD REJECTED</p>` : (a[0].final_status == 3) ? `<p>COD APPROVED & DEAN APPROVED</p>` : (a[0].final_status == 4) ? `<p>COD APPROVED & DEAN REJECTED</p>` : (a[0].final_status == 5) ? `<p>COD REJECTED & DEAN APPROVED</p>` : (a[0].final_status == 6) ? `<button id = 'reject-button' index = '${ a.applications_id }' class = 'btn btn-alt-warning' data-toggle = 'click-ripple'>Reject</button>` : (a[0].final_status == 7) ? `DEAN HAS PUSHED ACCEPTED APPLICATIONS` : (a[0].final_status == 8) ? `COD & DEAN HAS REJECTED`  : (a[0].final_status == 9) ? `<button id = 'reject-button' index = '${ a[0].applications_id }' class = 'btn btn-alt-warning' data-toggle = 'click-ripple'>Reject</button>` : (a[0].final_status == 10) ? `DEAN PUSHED REJECTED APPLICATION` : 'false'  }
                                        </div>
                                    `
                                }
                                <button id = 'view-more-level' pin = 'false' key = '${ k }' class = 'btn btn-alt-info' data-toggle = 'click-ripple'>View More</button>
                            </section>
                            <section class = 'inner-part-level${ k }' id = 'inner-part-level' style = 'display:none;'>
                                <h3>Academics Profile</h3>
                                <div id = 'other-table'>
                                    <div>
                                        <p>Institution</p>
                                        ${ a[0].institution }
                                    </div>
                                    <div>
                                        <p>Grade</p>
                                        ${ a[0].qualification }
                                    </div>
                                    <div>
                                        <p>Certificate</p>
                                        <a href = './../certs/${ a[0].certificate }' class = 'btn btn-alt-success'>Download</a>
                                    </div>
                                </div>
                                <h3>Work Profile</h3>
                                <div id = 'other-table'>
                                    <div>
                                        <p>Institution</p>
                                        ${ a[0].organization }
                                    </div>
                                    <div>
                                        <p>Job</p>
                                        ${ a[0].post }
                                    </div>
                                </div>
                                <h3>Application Process</h3>
                                <div id = 'other-table'>
                                    ${ (a[0].status) ? $.parseJSON(a[0].status).map( (s,k) =>
                                        `
                                        <section>
                                            <div id = 'number'>
                                                ${ (k + 1) }
                                            </div>
                                            <div>
                                                <p>Action</p>
                                                ${ (s.status == 1) ? `COD APPROVED` : (s.status == 2) ? `COD REJECTED` : (s.status == 3) ? `COD APPROVED & DEAN APPROVED` : (s.status == 4) ? `COD APPROVED & DEAN REJECTED` : (s.status == 5) ? `COD REJECTED & DEAN APPROVED` : (s.status == 6) ? `COD HAS APPROVED & PUSHED TO DEAN` : (s.status == 7) ? `DEAN HAS APPROVED & PUSHED FOR MAIL` : (s.status == 8) ? `COD REJECTED && DEAN REJECTED` : (s.status == 9) ? `COD REJECTED && PUSHED TO DEAN` : (s.status == 10) ? `DEAN HAS REJECTED && PUSHED TO MAIL` :  `STILL PENDING` }
                                            </div>
                                            <div>
                                                <p>Reason</p>
                                                ${ s.reason }
                                            </div>
                                            <div>
                                                <p>Designation</p>
                                                ${ s.level }
                                            </div>
                                            <div>
                                                <p>Date</p>
                                                ${ s.date }
                                            </div>
                                        </section>
                                        `
                                    ) : '<p>Not yet pushed</p>'
                                    }
                                </div>
                            </section>

                        `
                    )

                }
            }
            $('#candidate-page').html(approvals)
        };
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
        this.createGraph = (g) => {
            const { graph_data, text, id, label_one, label_two, label_three, type } = g
            let xValue = graph_data.map( b => b.intake );
            let countValue = graph_data.map( b => Number(b.count) );
            let approvalValue = graph_data.map( b => Number(b.approved) );
            let rejectedValue = graph_data.map( b => Number(b.rejected) );
            let pendingValue = graph_data.map( b => Number(b.pending) );

            let setApprove = approvalValue.reduce(ServerData.getSum, 0)
            let setRejected = rejectedValue.reduce(ServerData.getSum, 0)
            let setPending = pendingValue.reduce(ServerData.getSum, 0)

            $('#approved-preview').html(setApprove)
            $('#rejected-preview').html(setRejected)
            $('#pending-preview').html(setPending)

            let pieData = [
                setApprove,
                setRejected,
                setPending
            ]
            let backgroundColor = [
                window.chartColors.tum,
                window.chartColors.red,
                window.chartColors.gold
            ]
            let labels = [
                'Approved',
                'Rejected',
                'Pending'
            ]
            if(setPending == 0 && setRejected == 0 && setPending == 0){
                pieData = [100]
                backgroundColor = [window.chartColors.tum]
                labels = ['No Data']
            }
            var chartData = {
				datasets : [{
					data : pieData,
					backgroundColor : backgroundColor,
					label : text
				}],
				labels : labels
            }
            console.log(approvalValue)
            console.log(rejectedValue)
            console.log(pendingValue)
            console.log(countValue)

            if(type == "bar"){
                let xBind = ["One","Two","Three","Four","Five","Six","Seven","Eight","Nine","Ten"]
                let datasets = [
                    {
                        type: 'bar',
                        label: "No Data",
                        backgroundColor: window.chartColors.tum,
                        data:[1,2,3,4,5,6,7,8,9,10],
                        borderColor: 'white',
                        borderWidth: 2
                    },
                    {
                        type : 'line',
                        label : "No Data",
                        borderColor : window.chartColors.gold,
                        borderWidth : 2,
                        fill : false,
                        data : [1,2,3,4,5,6,7,8,9,10]
                    }
                ]
                if(countValue.length > 0){
                    xBind = xValue
                    datasets = [
                        {
                            type: 'line',
                            label: "Total Applications",
                            borderColor: window.chartColors.blue,
                            borderWidth: 2,
                            fill: false,
                            data: countValue
                        },
                        {
                            type: 'bar',
                            label: "Approved",
                            backgroundColor: window.chartColors.red,
                            data:approvalValue,
                            borderColor: 'white',
                            borderWidth: 2
                        },
                        {
                            type: 'bar',
                            label: "Rejected",
                            backgroundColor: window.chartColors.tum,
                            data: rejectedValue,
                            borderColor: 'white',
                            borderWidth: 2
                        },
                        {
                            type: 'bar',
                            label: "Pending",
                            backgroundColor: window.chartColors.gold,
                            data: pendingValue,
                            borderColor: 'white',
                            borderWidth: 2
                        }
                    ]
                }
                chartData = {
                    labels : xBind,
                    datasets
                };
            }
            var ctx = document.getElementById(id).getContext('2d');
            window.myMixedChart = new Chart(ctx, {
                type,
                data: chartData,
                options: {
                    responsive: true,
                    title: {
                        display: true,
                        text
                    },
                    tooltips: {
                        mode: 'index',
                        intersect: true
                    }
                }
            });
        }
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
        let list_data = await ServerData.bindAuth('POST',"approval/fetchData",true,{ id })
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
                            </div>
                        </section>
                    </div>
                `
            )
        }
        $('.content-force').html(list_string)
    }

    const showCourses = async() => {
        let collect = await ServerData.bindAuth('GET',`approval/getCourses`,false)
        console.log(collect)
        let collect_string = collect.course.map( c =>
            `
                <div id = 'create-intake'>
                    <p>Course Name : ${ c.name }</p>
                    <div class = 'main-intake'>
                        ${
                            $.parseJSON(c.units).map( s =>
                                `
                                    <section>
                                        <p>Unit Name</p>
                                        ${ s.name }
                                    </section>
                                    <section>
                                        <p>Unit Code</p>
                                        ${ s.code }
                                    </section>
                                    <section>
                                        <button id = 'delete-course' style = 'height:40px;width:80%;' class = 'btn btn-alt-info' data-toggle = 'click-ripple'>DELETE</button>
                                    </section>
                                `
                            )
                        }
                    </div>
                </div>
            `
        )
        $('.content-force').html(collect_string)
    }
    const retrievePost = async() => {
        const app = sessionStorage.getItem('appId')
        const program = sessionStorage.getItem('programId')
        const name = sessionStorage.getItem('nameIntake')

        let collect = await ServerData.bindAuth('POST',`approval/getApplication`,true,{ 'app' : app })

        ServerData.collect = collect.app
        let courses = collect.courses
        let attendance = collect.attendance

        $('#intake_name').html(name)
        $('#intake_program').html(ServerData.studies[program])
        let stage_data = []
        ServerData.collect.map( data => {
            data.years.split(',').map( data => {
                stage_data.push({ 'id' : data + ',' + data, 'text' : data })
            })
        })

        let course_data = []
        if(courses.length > 0){
            courses.map((data, key) => {
                if(data.length > 0)
                    course_data.push({ 'id' : Number(data[0].id) + ',' + data[0].name, 'text' : data[0].name })
            })
        }else
            course_data.push({ 'id' : 0 + ',' + 0, 'text' : 'No courses' })

        let attendance_data = []
        if(attendance.length > 0){
            attendance.map((data) => {
                if(data.length > 0)
                    attendance_data.push({ 'id' : data.id + ',' + data.attendance_name, 'text' : data.attendance_name })
            })
        }else
            attendance_data.push({ 'id' : 0 + ',' + 0, 'text' : 'No Attendance' })

        ServerData.buildSelect({'id' : '#attendance_search', 'placeholder' : 'Preferred Attendance(Select)*', 'data' : attendance_data })
        ServerData.buildSelect({'id' : '#course_search', 'placeholder' : 'Programme/Course(Select)*', 'data' : course_data })
        ServerData.buildSelect({'id' : '#stage_search', 'placeholder' : 'Year of Study*', 'data' : stage_data })
        ServerData.beApproved(1,0);
    }
    const buildGraph = async(e) => {
        let graph_data = await ServerData.bindAuth('GET',`approval/graph`,false)
        console.log(graph_data)
        let plot = [
            {'go_id' : 'pie-cod','go_text' : 'Approved & Rejected Applications', 'type' : 'pie'},
            {'go_id' : 'bar-cod','go_text' : 'Approved & Rejected Applications Over Intakes', 'type' : 'bar'}
        ]
        plot.map( p => {
            const { go_id, go_text, type } = p
            ServerData.createGraph({'graph_data' : graph_data.graph, 'id' : go_id, 'text' : go_text, 'label_one' : go_text, 'label_two' : go_text, 'label_three' : go_text, 'type' : type })
        })
    }


    $(document).ready(function(){

        $(document).on('click','#view-application-list',function(e){
            e.preventDefault()
            sessionStorage.setItem('appId',e.currentTarget.attributes[1].value)
            sessionStorage.setItem('programId',e.currentTarget.attributes[2].value)
            sessionStorage.setItem('status',e.currentTarget.attributes[3].value)
            sessionStorage.setItem('nameIntake',e.currentTarget.attributes[4].value)
            document.location.assign(`approval/pendingView`)
        })
        $(document).on('click','#prev',function(e){
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
        $(document).on('click','#search-query-button', async(e) =>{
            e.preventDefault()
            const search = $('#search-input').val();
            let search_query = await ServerData.bindAuth('POST',`approval/getCandidate`,true,{ 'value' : search })
            console.log(search_query)
            let approvals = "<div id = 'time-out'><img src = './../Images/clipboard.svg'>Database Empty</div>"
            if(search_query.user){
                approvals = "<div id = 'time-out'><img src = './../Images/clipboard.svg'>Could not find data</div>"
                if(search_query.user.length > 0){
                    approvals = search_query.user.map( (a,k) =>
                        `
                            <section class = 'part-level'>
                                <div>
                                    <p>Name</p>
                                    ${ a.fname + ' ' + a.sname }
                                </div>
                                <div>
                                    <p>Telephone</p>
                                    ${ a.telephone }
                                </div>
                                <div>
                                    <p>Fee</p>
                                    ${ a.amount }
                                </div>
                                ${
                                    (search_query.role == 2)
                                    ?
                                    `
                                        <div>
                                            ${ (a.final_status == 0)? `<button id = 'approve-button' index = '${ a.applications_id }' class = 'btn btn-alt-success' data-toggle = 'click-ripple'>Approve</button>` : (a.final_status == 1) ? `<p>COD APPROVED</p>` : (a.final_status == 2) ? `<p>COD REJECTED</p>` : (a.final_status == 3) ? `<p>COD APPROVED & Dean APPROVED</p>` : (a.final_status == 4) ? `<p>COD APPROVED & DEAN REJECTED</p>` : (a.final_status == 5) ? `<p>COD REJECTED & DEAN APPROVED</p>` : (a.final_status == 6) ? `COD PUSHED APPROVED APPLICATION TO DEAN` : (a.final_status == 7) ? `DEAN PUSHED APPROVED APPLICATION FOR MAIL` : (a.final_status == 8) ? `COD & DEAN HAS REJECTED`   : (a.final_status == 9) ? `COD PUSHED REJECTED APPLICATION TO DEAN` : (a.final_status == 10) ? `DEAN PUSHED REJECTED APPLICATION TO MaIL`  : 'false'  }
                                        </div>
                                        <div>
                                            ${ (a.final_status == 0)? `<button id = 'reject-button' index = '${ a.applications_id }' class = 'btn btn-alt-warning' data-toggle = 'click-ripple'>Reject</button>` : (a.final_status == 1) ? `<button id = 'reject-button' index = '${ a.applications_id }' class = 'btn btn-alt-warning' data-toggle = 'click-ripple'>Reject</button>` : (a.final_status == 2) ? `<button id = 'approve-button' index = '${ a.applications_id }' class = 'btn btn-alt-success' data-toggle = 'click-ripple'>Approve</button>` : (a.final_status == 3) ? `<p>COD APPROVED & DEAN APPROVED</p>` : (a.final_status == 4) ? `<p>COD APPROVED & DEAN REJECTED APPLICATION</p>` : (a.final_status == 5) ? `<p>COD REJECTED & DEAN APPROVED APPLICATION</p>` : (a.final_status == 6) ? `COD PUSHED APPROVED APPLICATION TO DEAN`  : (a.final_status == 7) ? `DEAN PUSHED ACCEPTED APPLICATION FOR MAIL` : (a.final_status == 8) ? `COD & DEAN HAS REJECTED APPLICATION` : (a.final_status == 9) ? `COD PUSHED REJECTED APPLICATION TO DEAN` : (a.final_status == 10) ? `DEAN PUSHED REJECTED APPLICATION TO MAIL` : 'false'  }
                                        </div>
                                    `
                                    :
                                    `
                                        <div>
                                            ${  (a.final_status == 0)? `PENDING COD ACTION` : (a.final_status == 1) ? `<p>COD APPROVED</p>` : (a.final_status == 2) ? `<p>COD REJECTED</p>` : (a.final_status == 3) ? `<p>COD APPROVED & DEAN APPROVED</p>` : (a.final_status == 4) ? `<p>COD APPROVED & DEAN REJECTED</p>` : (a.final_status == 5) ? `<p>COD REJECTED & DEAN APPROVED</p>` : (a.final_status == 6) ? `<button id = 'approve-button' index = '${ a.applications_id }' class = 'btn btn-alt-success' data-toggle = 'click-ripple'>Approve</button>` : (a.final_status == 7) ? `DEAN HAS PUSHED ACCEPTED APPLICATIONS` : (a.final_status == 8) ? `COD & DEAN HAS REJECTED` : (a.final_status == 9) ? `<button id = 'approve-button' index = '${ a.applications_id }' class = 'btn btn-alt-success' data-toggle = 'click-ripple'>Approve</button>` : (a.final_status == 10) ? `DEAN PUSHED REJECTED APPLICATION` : 'false'  }
                                        </div>
                                        <div>
                                            ${  (a.final_status == 0)? `PENDING COD ACTION` : (a.final_status == 1) ? `<p>COD APPROVED</p>` : (a.final_status == 2) ? `<p>COD REJECTED</p>` : (a.final_status == 3) ? `<p>COD APPROVED & DEAN APPROVED</p>` : (a.final_status == 4) ? `<p>COD APPROVED & DEAN REJECTED</p>` : (a.final_status == 5) ? `<p>COD REJECTED & DEAN APPROVED</p>` : (a.final_status == 6) ? `<button id = 'reject-button' index = '${ a.applications_id }' class = 'btn btn-alt-warning' data-toggle = 'click-ripple'>Reject</button>` : (a.final_status == 7) ? `DEAN HAS PUSHED ACCEPTED APPLICATIONS` : (a.final_status == 8) ? `COD & DEAN HAS REJECTED`  : (a.final_status == 9) ? `<button id = 'reject-button' index = '${ a.applications_id }' class = 'btn btn-alt-warning' data-toggle = 'click-ripple'>Reject</button>` : (a.final_status == 10) ? `DEAN PUSHED REJECTED APPLICATION` : 'false'  }
                                        </div>
                                    `
                                }
                                <button id = 'view-more-level' pin = 'false' key = '${ k }' class = 'btn btn-alt-info' data-toggle = 'click-ripple'>View More</button>
                            </section>
                            <section class = 'inner-part-level${ k }' id = 'inner-part-level' style = 'display:none;'>
                                <h3>Academics Profile</h3>
                                <div id = 'other-table'>
                                    <div>
                                        <p>Institution</p>
                                        ${ a.institution }
                                    </div>
                                    <div>
                                        <p>Grade</p>
                                        ${ a.qualification }
                                    </div>
                                    <div>
                                        <p>Certificate</p>
                                        <a href = './../certs/${ a.certificate }' class = 'btn btn-alt-success'>Download</a>
                                    </div>
                                   
                                </div>
                                <h3>Work Profile</h3>
                                <div id = 'other-table'>
                                    <div>
                                        <p>Institution</p>
                                        ${ a.organization }
                                    </div>
                                    <div>
                                        <p>Job</p>
                                        ${ a.post }
                                    </div>
                                </div>
                                <h3>Application Process</h3>
                                <div id = 'other-table'>
                                    ${ (a.status) ? $.parseJSON(a.status).map( (s,k) =>
                                        `
                                            <section>
                                                <div id = 'number'>
                                                    ${ (k + 1) }
                                                </div>
                                                <div>
                                                    <p>Action</p>
                                                    ${ (s.status == 1) ? `COD APPROVED` : (s.status == 2) ? `COD REJECTED` : (s.status == 3) ? `COD APPROVED & DEAN APPROVED` : (s.status == 4) ? `COD APPROVED & DEAN REJECTED` : (s.status == 5) ? `COD REJECTED & DEAN APPROVED` : (s.status == 6) ? `COD HAS APPROVED & PUSHED TO DEAN` : (s.status == 7) ? `DEAN HAS APPROVED & PUSHED FOR MAIL` : (s.status == 8) ? `COD REJECTED && DEAN REJECTED` : (s.status == 9) ? `COD REJECTED && PUSHED TO DEAN` : (s.status == 10) ? `DEAN HAS REJECTED && PUSHED TO MAIL` :  `STILL PENDING` }
                                                </div>
                                                <div>
                                                    <p>Reason</p>
                                                    ${ s.reason }
                                                </div>
                                                <div>
                                                    <p>Designation</p>
                                                    ${ s.level }
                                                </div>
                                                <div>
                                                    <p>Date</p>
                                                    ${ s.date }
                                                </div>
                                            </section>
                                        `
                                    ) : '<p>Not yet pushed</p>'
                                    }
                                </div>
                            </section>
                            `
                    )

                }
            }
            $('#candidate-page').html(approvals)
        })
        $(document).on('click','#remove-modal',function(e){
            e.preventDefault();
            $('#fill-modal').remove();
        })
        $(document).on('click','#approve-button',async function(e){
            e.preventDefault()
            var check = confirm("Are you sure you want to approve?");
            if(check){
                let application_approve = await ServerData.bindAuth('POST',`approval/approveApplication`,true,{ 'application' : e.currentTarget.attributes[1].value, 'reason' : 'OK' })
                if(application_approve.user){
                    $('.content-force').append(`
                        <div id = 'fill-modal'>
                            <div id = 'inner-fill-modal'>
                                <img src = './../Images/success-tick.gif'>
                                <h3>Success!!</h3>
                            </div>
                        </div>
                    `)
                    setTimeout(
                        function(){
                            $('#fill-modal').remove()
                            ServerData.beApproved(ServerData.Page,0)
                        }
                    ,2000)
                }else{
                    $('.content-force').append(`
                        <div id = 'fill-modal'>
                            <div id = 'inner-fill-modal'>
                                <img src = './../Images/error-tick.jpg'>
                                <h3>There was an error. Try again</h3>
                            </div>
                        </div>
                    `)
                    setTimeout(
                        function(){
                            $('#fill-modal').remove()
                        }
                    ,2000)
                }
            }
        })
        $(document).on('click','#confirm-reject',async function(e){
            e.preventDefault()
            let reason = $('#rejection-reason').val()
            if(reason){
                let application_reject = await ServerData.bindAuth('POST',`approval/rejectApplication`,true,{ 'application' : e.currentTarget.attributes[1].value, 'reason' : reason })
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
                    setTimeout(function(){ $('#fill-modal').remove() },2000)
                }
            }else
                alert('Give a reason')
        })
        $(document).on('click','#push-list',async function(e){
            var check = confirm("Are you sure you want to push?");
            if(check){
                let status = e.currentTarget.attributes[2].value
                let pushed = await ServerData.bindAuth('POST',`approval/push`,true,{ 'intake' : e.currentTarget.attributes[1].value, status  })
                console.log(pushed)
                if(pushed.now){
                    $('.content-force').append(`
                        <div id = 'fill-modal'>
                            <div id = 'inner-fill-modal'>
                                <img src = './../Images/success-tick.gif'>
                                <h3>Success!!</h3>
                            </div>
                        </div>
                    `)
                    setTimeout(
                        function(){
                            $('#fill-modal').remove()
                            retrieveApplication(status)
                        }
                    ,2000)
                }else{
                    $('.content-force').append(`
                        <div id = 'fill-modal'>
                            <div id = 'inner-fill-modal'>
                                <img src = './../Images/error-tick.jpg'>
                                <h3>There was an error. Try again</h3>
                            </div>
                        </div>
                    `)
                    setTimeout(
                        function(){
                            $('#fill-modal').remove()
                        }
                    ,2000)
                }

            }
        })
        $(document).on('click','#reject-button',async function(e){
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
        $(document).on('click','#preview-cod section',function(e){
            e.preventDefault()
            document.location.assign(e.currentTarget.attributes[0].value);
        })
        $(document).on('click','#cancel',function(e){
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
        $(document).on('click','#view-more-level',function(e){
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
        $(document).on('keyup','.personal_input',function(e){
            e.preventDefault();
            ServerData.plotLegend({ 'id' : e.currentTarget.attributes[1].value, 'value' : e.currentTarget.value })
        })

    })
