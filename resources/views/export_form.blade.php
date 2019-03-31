<form class="batch-export-form" data-request-url="{{route('export.start')}}">
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
    </section>
</form>

<script type="text/javascript">
    (function() {
        
        function ExportProgress(form) {
            var self = this;
            form.addEventListener('submit', function(event){
                self.request_export(event);
            });
            this.form = form;
            this.element = form.querySelector('progress');
            this.current = 0;
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
        }

        ExportProgress.prototype.start = function(xhr) {
            var response = JSON.parse(xhr.responseText);
            console.log(response);
            //export_progress.pinging = window.setInterval(batch_request, 1000);
            //export_progress.url.searchParams.set('name', name);
        }

        // form.querySelector('section').style.display = 'block';

        document.addEventListener('DOMContentLoaded', function() {
            var forms = document.querySelectorAll('form.batch-export-form');
            forms.forEach( function(form){ 
                new ExportProgress(form);
            });
        });

        function batch_response() {
            var response = JSON.parse(this.responseText);

            export_progress.current = response.batch;
            export_progress.progress.value = export_progress.current;
            console.log(export_progress.current);
            if (response.url) {
                window.clearInterval(export_progress.pinging);
                var download_link = document.querySelector('section p a');
                download_link.href = response.url;
                download_link.style.display = 'inline';
            }
        }

        function batch_request() {
            var xhr = new XMLHttpRequest();
            xhr.addEventListener('load', batch_response);
            var url = export_progress.url;
            url.searchParams.set('batch', export_progress.current);
            url.searchParams.set('batch', export_progress.current);
            xhr.open('GET', url.toString());
            xhr.send();
        }

    })();
</script>

