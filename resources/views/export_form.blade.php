<form 
    class="batch-export-form" 
    data-request-url="{{route('export.start')}}"
    data-export-url="{{route('export.progress')}}"
    data-exporter="{{$data_export}}"
>
    <input type="hidden" name="data_export" value="{{$data_export}}" />
    <select name="interval">
        <option value="today" selected> Today </option>
        <option value="this_week"> This Week </option>
        <option value="last_week"> Last Week </option>
        <option value="this_month"> This Month </option>
        <option value="last_month"> Last Month </option>
        <option value="all"> Everthing </option>
    </select>
    <button> Export </button>
    <section class="progress-section" style="display:none">
        <label for="batch_progress"> Export progress </label>
        <progress max=""> 
            Starting 
        </progress>
        <a href="" style="display:none"> Download ready </a>
    </section>
</form>

<script type="text/javascript">
    (function() {

        document.addEventListener('DOMContentLoaded', function() {
            var forms = document.querySelectorAll('form.batch-export-form');
            forms.forEach( function(form){ 
                new ExportProgress(form);
            });
        });
        
        function ExportProgress(form) {
            var self = this;
            form.addEventListener('submit', function(event){
                self.request_export(event);
            });
            this.form = form;
            this.element = form.querySelector('progress');
            this.current = 0;
            this.exporter = form.dataset.exporter;
        };

        ExportProgress.prototype.request_export = function(event) {
            event.preventDefault();
            var xhr = new XMLHttpRequest();
            var self = this;
            xhr.addEventListener('load', function(){
                self.start(this);
            });
            var data = new FormData(this.form);
            xhr.open('POST', this.form.dataset.requestUrl);
            var csrf_token = document.querySelector('meta[name="csrf-token"]').content;
            xhr.setRequestHeader('X-CSRF-TOKEN', csrf_token);
            xhr.send(data);
        };

        ExportProgress.prototype.start = function(xhr) {
            this.params = JSON.parse(xhr.responseText);
            this.element.max = this.params.max;
            this.element.current = this.current = 0;
            if (this.params.max == 0) {
                alert('empty set');
                return;
            }
            this.batch_request();
            var self = this;
            this.pinging = window.setInterval(function() {
                self.batch_request();
            }, 1000);
            this.form.querySelector('section').style.display = 'block';
        };


        ExportProgress.prototype.batch_request = function() {
            var xhr = new XMLHttpRequest();
            var self = this;
            xhr.addEventListener('load', function(event) {
                self.batch_response(this);
            });
            var url = new URL(this.form.dataset.exportUrl);
            url.searchParams.set('exporter', this.exporter);
            url.searchParams.set('batch', this.current);
            url.searchParams.set('name', this.params.name);
            if (Array.isArray(this.params.interval)) {
                this.params.interval.forEach(function(item) {
                    url.searchParams.append('interval[]', item);
                });
            }
            xhr.open('GET', url.toString());
            xhr.send();
        };


        ExportProgress.prototype.batch_response = function(xhr) {
            var response = JSON.parse(xhr.responseText);

            this.element.value = this.current = response.batch;
            console.log(this.current);
            if (response.url) {
                window.clearInterval(this.pinging);
                var download_link = this.form.querySelector('section a');
                download_link.href = response.url;
                download_link.style.display = 'inline';
                window.location = response.url;
            }
        }

    })();
</script>

