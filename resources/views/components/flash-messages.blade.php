@if (session()->has('flash_massages'))
    <div class="z-30 sm:w-auto fixed top-2 left-2 sm:left-auto sm:left-0 right-2 flex flex-col space-y-2 cursor-default"
         onmouseover="this.style.display='none'"
         id="flash-messages">
        @foreach (session()->get('flash_massages') as $message)
            <x-flash-message
                    :level="$message['level']"
                    :content="$message['content']" />
        @endforeach
    </div>

    <script>
        setTimeout(fn => document.getElementById('flash-messages').remove(), 5000);
    </script>

    @php
        session()->remove('flash_massages');
    @endphp
@endif