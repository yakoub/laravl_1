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
                export_progress.current = parseInt(this.responseText);
                if (export_progress.current >= parseInt(export_progress.progress.max)) {
                    window.clearInterval(export_progress.pinging);
                }
                export_progress.progress.value = export_progress.current;
                console.log(export_progress.current);
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
