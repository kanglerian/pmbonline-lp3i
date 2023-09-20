<script>
  var urlData = 'get/databases';
    var urlExcel = 'applicants/export';

    var dataTableInitialized = false;
    var dataTableInstance;

    var dataApplicants;

    const getAPI = () => {
        fetch(urlData)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                const count = data.applicants.length;
                dataApplicants = data.applicants;
                document.getElementById('count_filter').innerText = count;
            })
            .catch(error => {
                console.error('Error fetching data:', error);
            });
    }

    const changeFilter = () => {
        let queryParams = [];
        
        let dateStart = document.getElementById('date_start').value || 'all';
        let dateEnd = document.getElementById('date_end').value || 'all';
        let yearGrad = document.getElementById('year_grad').value || 'all';
        let schoolVal = document.getElementById('school').value || 'all';
        let birthdayVal = document.getElementById('birthday').value || 'all';
        let pmbVal = document.getElementById('change_pmb').value || 'all';
        let comeVal = document.getElementById('change_come').value || 'all';
        let achievementVal = document.getElementById('change_achievement').value || 'all';
        let followVal = document.getElementById('change_follow').value || 'all';
        let sourceVal = document.getElementById('change_source').value || 'all';
        let statusVal = document.getElementById('change_status').value || 'all';
        let kipVal = document.getElementById('change_kip').value || 'all';
        let relationVal = document.getElementById('change_relation').value || 'all';

        if (dateStart !== 'all') {
            queryParams.push(`dateStart=${dateStart}`);
        }
        if (dateEnd !== 'all') {
            queryParams.push(`dateEnd=${dateEnd}`);
        }
        if (yearGrad !== 'all') {
            queryParams.push(`yearGrad=${yearGrad}`);
        }
        if (schoolVal !== 'all') {
            queryParams.push(`schoolVal=${schoolVal}`);
        }
        if (birthdayVal !== 'all') {
            queryParams.push(`birthdayVal=${birthdayVal}`);
        }
        if (achievementVal !== 'all') {
            queryParams.push(`achievementVal=${achievementVal}`);
        }
        if (pmbVal !== 'all') {
            queryParams.push(`pmbVal=${pmbVal}`);
        }
        if (sourceVal !== 'all') {
            queryParams.push(`sourceVal=${sourceVal}`);
        }
        if (statusVal !== 'all') {
            queryParams.push(`statusVal=${statusVal}`);
        }
        if (followVal !== 'all') {
            queryParams.push(`followVal=${followVal}`);
        }
        if (comeVal !== 'all') {
            queryParams.push(`comeVal=${comeVal}`);
        }
        if (kipVal !== 'all') {
            queryParams.push(`kipVal=${kipVal}`);
        }
        if (relationVal !== 'all') {
            queryParams.push(`relationVal=${relationVal}`);
        }

        let queryString = queryParams.join('&');

        urlData = `get/databases?${queryString}`;
        urlExcel = `applicants/export?${queryString}`;

        if (dataTableInitialized) {
            dataTableInstance.ajax.url(urlData).load();
            getAPI();
        } else {
            getDataTable();
        }   
    }

    const resetFilter = () => {
        urlData = `get/databases`;
        urlExcel = 'applicants/export';
        if (dataTableInitialized) {
            dataTableInstance.ajax.url(urlData).load();
            getAPI();
            document.getElementById('date_start').value = '';
            document.getElementById('date_end').value = '';
            document.getElementById('year_grad').value = '';
            document.getElementById('school').value = '';
            document.getElementById('birthday').value = '';
            document.getElementById('change_pmb').value = '';
            document.getElementById('change_achievement').value = '';
            document.getElementById('change_relation').value = '';
            document.getElementById('change_kip').value = 'all';
            document.getElementById('change_come').value = 'all';
            document.getElementById('change_follow').value = 'all';
            document.getElementById('change_source').value = 'all';
            document.getElementById('change_status').value = 'all';
        } else {
            getDataTable();
        }
    }
</script>