<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<style>
    .input-group {
        margin-left: 20%;
        margin-right: 15%;
        display: flex;

    }

    .timer {
        width: 80px;
    }

    .input-group input {
        flex: 1;
        /* faz com que os inputs compartilhem a largura */
        margin-right: 1px;
        /* adiciona um espaçamento entre os inputs */
    }

    .dropbtn:hover,
    .dropbtn:focus {
        background-color: white;
        border-top: none;
        border-left: none;
        border-right: none;
        border-width: 2px;
        border-color: red;
    }

    .dropdown {
        margin-left: 20%;
        margin-right: 15%;
    }

    .dropdown-content {
        display: none;
        background-color: white;
        width: 97.5%;
        overflow: auto;
        z-index: 1;
        padding: 5px;
        border-style: solid;
        border-color: #92a8d1;
        border-width: 1px;
        flex-grow: 1;
        top: 100%;
        /* Posiciona abaixo do elemento pai */
        right: 0;
        ;
        /* Alinha com a borda esquerda do elemento pai */
    }

    .dropdown-content a {
        color: black;
        padding: 12px 16px;
        text-decoration: none;
        display: block;
    }

    .dropdown a:hover {
        background-color: #ddd;
    }

    .show {
        display: inline-block;
    }
</style>
<div class="input-group" >
    <input type="text" class="flatpickr" id="datepicker" style="height: 40px; padding-left: 10px;" placeholder="escolha a data:">

    <script>
        flatpickr("#datepicker", {
            minDate: "today",
            dateFormat: "d/m/Y",
            onChange: function(selectedDates, dateStr, instance) {
                // Call the function to update the dropdown with available times
                updateDropdown(dateStr);
            }
        });
        // Function to update the dropdown with available times
        function updateDropdown(selected_date) {
            // Format the date in the way that the API endpoint expects
            var formatted_date = selected_date.split('/').reverse().join('');
            // Make a request to the API endpoint
            var url = 'https://edigcia.ediprinter.pt/edigciaappointmentapi/GetAppointmentsTimeFree/' + encodeURIComponent('80d2f00e2937f6cca61189d13b9e0c7d95f5c01a4f21e0daa8be14a8') + '/1/' + encodeURIComponent(formatted_date) + '/false';
            $.ajax({
                url: url,
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    document.getElementById("timer").disabled = false;
                    $('#timer').empty();
                    // Add each value in the response as a new option
                    for (var i = 0; i < response.length; i++) {
                        var value = response[i];
                        var label = value;
                        $('#timer').append($('<option>', {
                            value: value,
                            text: label
                        }));
                    }

                },
                error: function(xhr, status, error) {
                    // Callback de erro
                    console.log(xhr.responseText);
                }
            });
        }
    </script>


    <select name="timer" id="timer" placeholder="horas" class="timer" style="height: 40px; padding-left: 10px" required disabled>
        <option value=" "> </option>
    </select>
    <script>
        document.getElementById("timer").addEventListener("change", function() {
            myFunction();
        });
    </script>

    <button onclick="myFunction()" style=" height: 40px; padding-left: 10px; width:60%;max-width:68%;" class="dropbtn">OS SEUS DADOS</button>


</div>
</div>
<script>

    function myFunction() {
        document.getElementById("myDropdown").classList.toggle("show");
    }

</script>
<div class="dropdown" id="dropdown">


    <div id="myDropdown" class="dropdown-content">
        <br>
        <input type="text" id="nome" name="nome" placeholder="NOME*" required disabled>

        <input type="email" id="email" name="email" placeholder="email*" required disabled>

        <input type="tel" id="tel" name="tel" pattern="[0-9]{9}" placeholder="Tel*" required disabled>

        <input type="text" id="matricula" name="matricula" pattern="[A-Za-z0-9]{2}-[A-Za-z0-9]{2}-[A-Za-z0-9]{2}" placeholder="Matricula*" required disabled>

        <br><br>

        <select name="category" id="category" placeholder="Categoria*" required disabled>
            <option value="1">Ligeiro</option>
            <option value="2">Pesado</option>
            <option value="3">Trator</option>
            <option value="4">Motociclo</option>
            <option value="4">Triciclo</option>
            <option value="4">Quadriciclo</option>
            <option value="6">Reboque</option>
            <option value="7">Semi-Reboque</option>
            <option value="9">Trator > 3500KG</option>
        </select>


        <select name="motive" id="motive" placeholder="Motivo*" required disabled>
            <option value="1">Inspeção Periodica</option>
            <option value="2">Reinspecção</option>
            <option value="3">Insp. p/atrib. nova matricula</option>
            <option value="4">Inspeção Extraordinária</option>
            <option value="5">Inspeção facultativa</option>
            <option value="7">Insp. téc.min.na estr.deter.p/imt</option>
            <option value="31">Reinsp.p/atrib.nova matricula</option>
            <option value="41">Reinspeção extraordinária</option>



        </select>

        <script>
            const input = document.getElementById('matricula');
            input.addEventListener('input', function(event) {
                let value = event.target.value.replace(/[^A-Za-z0-9]/g, '').toUpperCase();
                let formattedValue = value.slice(0, 2) + '-' + value.slice(2, 4) + '-' + value.slice(4, 6);
                event.target.value = formattedValue;
            });
        </script>




        <p>
            <input type="checkbox" id="politica_privacidade" name="politica_privacidade" required>
            <label for="politica_privacidade">Tomei conhecimento da Política de Privacidade da Insparedes.</label>
        </p>

        <button type="submit" onclick="insertApp()" id="submit" style="margin:10px">Enviar</button>

        </form>

        <script>
            var form = document.getElementById("myDropdown");
            var inputs = form.querySelectorAll("input, textarea, select");
            document.getElementById("timer").addEventListener("change", function() {
                if (this.value) {
                    for (var i = 0; i < inputs.length; i++) {
                        inputs[i].disabled = false;
                    }
                    /* document.getElementById("dropdown").submit.disabled = false;*/
                } else {
                    for (var i = 0; i < inputs.length; i++) {
                        inputs[i].disabled = true;
                    }
                    document.getElementById("dropdown").submit.disabled = true;
                }
            });

            function insertApp() {
                var formatted_date = document.getElementById("datepicker").value;
                var formatted_date = formatted_date.split('/').reverse().join('');
                var licensePlate = document.getElementById("matricula").value;
                var nameInput = document.getElementById("nome");
                var name = nameInput.value;
                var email = document.getElementById("email").value;
                var phone = document.getElementById("tel").value;
                var hour = document.getElementById("timer").value;
                hour = hour.replace(/:/g, "");
                var form = document.getElementById("dropdown");
                var category = document.getElementById("category").value;
                var motive = document.getElementById("motive").value;
                console.log(hour)
                console.log(formatted_date)
                document.getElementById("myDropdown").form.addEventListener("myDropdown", function(event) {
                    event.preventDefault();
                    console.log(formatted_date);
                    console.log(name);
                    console.log(licensePlate);
                    console.log("Form submitted!");
                    var url = 'https://edigcia.ediprinter.pt/edigciaappointmentapi/InsertAppointment/' + encodeURIComponent('80d2f00e2937f6cca61189d13b9e0c7d95f5c01a4f21e0daa8be14a8') + '/1/' + encodeURIComponent(formatted_date) + '/' + encodeURIComponent(hour) + '/' + encodeURIComponent(licensePlate) + '/' + encodeURIComponent(name) + '/' + encodeURIComponent(email) + '/' + encodeURIComponent(phone) + '/' + encodeURIComponent(category) + '/' + encodeURIComponent(motive);
                    $.ajax({
                        url: url,
                        type: 'PUT',
                        dataType: 'json',
                        success: function(response) {
                            // Clear existing options in the dropdown
                            console.log(response)
                        },
                        error: function(xhr, status, error) {
                            // Callback de erro
                            console.log(xhr.responseText);
                        }
                    });
                });
            }
        </script>

    </div>
    </body>

    </html>