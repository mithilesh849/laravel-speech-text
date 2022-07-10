<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
   <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <title>Laravel-IVR</title>
      <!-- Fonts -->
      <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
      <!--  -->
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
      <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
      <link rel="stylesheet" href="{{ asset('assets/style.css') }}">
      <style>
         body {
         font-family: 'Nunito', sans-serif;
         }
      </style>
   </head>
   <body class="antialiased">
      <div class="container">
         <div class="row">
            <div class="col-sm-12 ">
               <h1 class="center" id="headline">Extreme Agile</h1>

               <div class="alert alert-success" role="alert" id="successMsg" style="display: none" >
                 Thank you, data has been saved! 
               </div>


               <div id="info">
                  <p id="info_start">Click on the microphone icon and begin speaking.</p>
                  <p id="info_speak_now">Speak now.</p>
                  <p id="info_no_speech">No speech was detected. You may need to adjust your
                     <a href="//support.google.com/chrome/bin/answer.py?hl=en&amp;answer=1407892">
                     microphone settings</a>.
                  </p>
                  <p id="info_no_microphone" style="display:none">
                     No microphone was found. Ensure that a microphone is installed and that
                     <a href="//support.google.com/chrome/bin/answer.py?hl=en&amp;answer=1407892">
                     microphone settings</a> are configured correctly.
                  </p>
                  <p id="info_allow">Click the "Allow" button above to enable your microphone.</p>
                  <p id="info_denied">Permission to use microphone was denied.</p>
                  <p id="info_blocked">Permission to use microphone is blocked. To change,
                     go to chrome://settings/contentExceptions#media-stream
                  </p>
                  <p id="info_upgrade">Web Speech API is not supported by this browser.
                     Upgrade to <a href="//www.google.com/chrome">Chrome</a>
                     version 25 or later.
                  </p>
               </div>
               <div class="right">
                  <button id="start_button" onclick="startButton(event)">
                  <img id="start_img" src="{{ asset('assets/mic.gif') }}" alt="Start"></button>
               </div>
               <div id="results">
                  <span id="final_span" class="final"></span>
                  <span id="interim_span" class="interim"></span>
                  <p>
               </div>
               <div class="center">
                  <div class="sidebyside" style="text-align:right">
                     <button id="save_button" class="btn btn-success" >
                     Save Now</button>
                     
                  </div>
                 
                  <p>
                  <div id="div_language">
                     <select id="select_language" onchange="updateCountry()"></select>
                     &nbsp;&nbsp;
                     <select id="select_dialect"></select>
                  </div>
               </div>
            </div>
         </div>
      </div>

<script type="text/javascript">
        
var langs =
[['Afrikaans',       ['af-ZA']],
 ['Bahasa Indonesia',['id-ID']],
 ['Bahasa Melayu',   ['ms-MY']],
 ['Català',          ['ca-ES']],
 ['Čeština',         ['cs-CZ']],
 ['Deutsch',         ['de-DE']],
 ['English',         ['en-AU', 'Australia'],
                     ['en-CA', 'Canada'],
                     ['en-IN', 'India'],
                     ['en-NZ', 'New Zealand'],
                     ['en-ZA', 'South Africa'],
                     ['en-GB', 'United Kingdom'],
                     ['en-US', 'United States']],
 ['Español',         ['es-AR', 'Argentina'],
                     ['es-BO', 'Bolivia'],
                     ['es-CL', 'Chile'],
                     ['es-CO', 'Colombia'],
                     ['es-CR', 'Costa Rica'],
                     ['es-EC', 'Ecuador'],
                     ['es-SV', 'El Salvador'],
                     ['es-ES', 'España'],
                     ['es-US', 'Estados Unidos'],
                     ['es-GT', 'Guatemala'],
                     ['es-HN', 'Honduras'],
                     ['es-MX', 'México'],
                     ['es-NI', 'Nicaragua'],
                     ['es-PA', 'Panamá'],
                     ['es-PY', 'Paraguay'],
                     ['es-PE', 'Perú'],
                     ['es-PR', 'Puerto Rico'],
                     ['es-DO', 'República Dominicana'],
                     ['es-UY', 'Uruguay'],
                     ['es-VE', 'Venezuela']],
 ['Euskara',         ['eu-ES']],
 ['Français',        ['fr-FR']],
 ['Galego',          ['gl-ES']],
 ['Hrvatski',        ['hr_HR']],
 ['IsiZulu',         ['zu-ZA']],
 ['Íslenska',        ['is-IS']],
 ['Italiano',        ['it-IT', 'Italia'],
                     ['it-CH', 'Svizzera']],
 ['Magyar',          ['hu-HU']],
 ['Nederlands',      ['nl-NL']],
 ['Norsk bokmål',    ['nb-NO']],
 ['Polski',          ['pl-PL']],
 ['Português',       ['pt-BR', 'Brasil'],
                     ['pt-PT', 'Portugal']],
 ['Română',          ['ro-RO']],
 ['Slovenčina',      ['sk-SK']],
 ['Suomi',           ['fi-FI']],
 ['Svenska',         ['sv-SE']],
 ['Türkçe',          ['tr-TR']],
 ['български',       ['bg-BG']],
 ['Pусский',         ['ru-RU']],
 ['Српски',          ['sr-RS']],
 ['한국어',            ['ko-KR']],
 ['中文',             ['cmn-Hans-CN', '普通话 (中国大陆)'],
                     ['cmn-Hans-HK', '普通话 (香港)'],
                     ['cmn-Hant-TW', '中文 (台灣)'],
                     ['yue-Hant-HK', '粵語 (香港)']],
 ['日本語',           ['ja-JP']],
 ['Lingua latīna',   ['la']]];


for (var i = 0; i < langs.length; i++) {
  select_language.options[i] = new Option(langs[i][0], i);
}

select_language.selectedIndex = 6;
updateCountry();
select_dialect.selectedIndex = 6;
showInfo('info_start');

function updateCountry() {
  for (var i = select_dialect.options.length - 1; i >= 0; i--) {
    select_dialect.remove(i);
  }
  var list = langs[select_language.selectedIndex];
  for (var i = 1; i < list.length; i++) {
    select_dialect.options.add(new Option(list[i][1], list[i][0]));
  }
  select_dialect.style.visibility = list[1].length == 1 ? 'hidden' : 'visible';
}

var create_email = false;
var final_transcript = '';
var recognizing = false;
var ignore_onend;
var start_timestamp;
if (!('webkitSpeechRecognition' in window)) {
  upgrade();
} else {
  start_button.style.display = 'inline-block';
  var recognition = new webkitSpeechRecognition();
  recognition.continuous = true;
  recognition.interimResults = true;

  recognition.onstart = function() {
    recognizing = true;
    showInfo('info_speak_now');
    start_img.src = "{{ asset('assets/mic-animate.gif') }}";
  };

  recognition.onerror = function(event) {
    if (event.error == 'no-speech') {
      start_img.src = "{{ asset('assets/mic.gif') }}";
      showInfo('info_no_speech');
      ignore_onend = true;
    }
    if (event.error == 'audio-capture') {
      start_img.src = "{{ asset('assets/mic.gif') }}";
      showInfo('info_no_microphone');
      ignore_onend = true;
    }
    if (event.error == 'not-allowed') {
      if (event.timeStamp - start_timestamp < 100) {
        showInfo('info_blocked');
      } else {
        showInfo('info_denied');
      }
      ignore_onend = true;
    }
  };

  recognition.onend = function() {
    recognizing = false;
    if (ignore_onend) {
      return;
    }
    start_img.src = "{{ asset('assets/mic.gif')}}";
    if (!final_transcript) {
      showInfo('info_start');
      return;
    }
    showInfo('');
    if (window.getSelection) {
      window.getSelection().removeAllRanges();
      var range = document.createRange();
      range.selectNode(document.getElementById('final_span'));
      window.getSelection().addRange(range);
    }
    
  };

  recognition.onresult = function(event) {
    var interim_transcript = '';
    for (var i = event.resultIndex; i < event.results.length; ++i) {
      if (event.results[i].isFinal) {
        final_transcript += event.results[i][0].transcript;
      } else {
        interim_transcript += event.results[i][0].transcript;
      }
    }
    final_transcript = capitalize(final_transcript);
    final_span.innerHTML = linebreak(final_transcript);
    interim_span.innerHTML = linebreak(interim_transcript);
    if (final_transcript || interim_transcript) {
      showButtons('inline-block');
    }
  };
}

function upgrade() {
  start_button.style.visibility = 'hidden';
  showInfo('info_upgrade');
}

var two_line = /\n\n/g;
var one_line = /\n/g;
function linebreak(s) {
  return s.replace(two_line, '<p></p>').replace(one_line, '<br>');
}

var first_char = /\S/;
function capitalize(s) {
  return s.replace(first_char, function(m) { return m.toUpperCase(); });
}


function startButton(event) {
  if (recognizing) {
    recognition.stop();
    return;
  }
  final_transcript = '';
  recognition.lang = select_dialect.value;
  recognition.start();
  ignore_onend = false;
  final_span.innerHTML = '';
  interim_span.innerHTML = '';
  start_img.src = "{{ asset('assets/mic-slash.gif') }}";
  showInfo('info_allow');
  showButtons('none');
  start_timestamp = event.timeStamp;
}

function showInfo(s) {
  if (s) {
    for (var child = info.firstChild; child; child = child.nextSibling) {
      if (child.style) {
        child.style.display = child.id == s ? 'inline' : 'none';
      }
    }
    info.style.visibility = 'visible';
  } else {
    info.style.visibility = 'hidden';
  }
}

var current_style;
function showButtons(style) {
  if (style == current_style) {
    return;
  }
  current_style = style;
  
}

 //save data
   $(document).on('click', '#save_button', function(event) {
       event.preventDefault();
       // alert("test");

       var n = final_transcript.indexOf('\n');
        if (n < 0 || n >= 80) {
          n = 40 + final_transcript.substring(40).indexOf(' ');
        }
        var text_data = encodeURI(final_transcript.substring(0, n));

       $.ajax({
           type: "post",
           url: "{{ url('saveData') }}",
           data: {'text_data':text_data,"_token": "{{ csrf_token() }}"},
           success: function(data) {

               $('.is-invalid').removeClass('is-invalid');
               if (data.fail) {
                   
               } else {
                  $("#successMsg").css("display","block");
               }
           },
           error: function(xhr, textStatus, errorThrown) {
               console.log("Error: " + errorThrown);
           }
       });
       return false;
   });
</script>


   </body>
</html>
