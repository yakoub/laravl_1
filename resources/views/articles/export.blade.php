@extends('page')

@section('title', 'Export Articles')

@section('content')
    <section>
        <header>
            <h3>
                <label for="batch_progress"> Export progress </label>
                <progress id="batch_progress" max="{{$max}}"> Starting </progress>
            </h3>
        </header>
        <p>
            Exporting
            <a href="" style="display:none"> download ready </a>
        </p>
    </section>
    <script type="text/javascript">
        (function() {
            var export_progress = {
                url: new URL(window.location.toString()),
                progress: null,
                current: 0
            };

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
                export_progress.url.searchParams.set('batch', export_progress.current);
                xhr.open('GET', export_progress.url.toString());
                xhr.send();
            }

            document.addEventListener('DOMContentLoaded', function() {
                export_progress.progress = document.querySelector('#batch_progress');
                export_progress.pinging = window.setInterval(batch_request, 1000);
            });
        })();
    </script>
@endsection
