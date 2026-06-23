document.addEventListener("DOMContentLoaded", function() {
    
    // 1. INICIALIZAR EL CALENDARIO
    const inputsFechas = document.querySelectorAll('.input-rango-fechas');

    inputsFechas.forEach(input => {
        const fechasBloqueadas = JSON.parse(input.getAttribute('data-ocupadas'));

        flatpickr(input, {
            mode: "range",              
            minDate: "today",           
            dateFormat: "Y-m-d",        
            locale: "es",               
            disable: fechasBloqueadas,  
            showMonths: 1,
            
            // --- NUEVO: LIMITAR A 31 DÍAS DINÁMICAMENTE ---
            onChange: function(selectedDates, dateStr, instance) {
                // Cuando selecciona el primer día (Retiro)
                if (selectedDates.length === 1) {
                    // Calculamos la fecha límite (Retiro + 31 días)
                    let limiteMaximo = new Date(selectedDates[0]);
                    limiteMaximo.setDate(limiteMaximo.getDate() + 31);
                    
                    // Bloqueamos que pueda hacer clic más allá de ese límite
                    instance.set("maxDate", limiteMaximo);
                } 
                // Cuando selecciona el segundo día (Devolución)
                else if (selectedDates.length === 2) {
                    // Liberamos el límite visual por si decide borrar y elegir otro mes
                    instance.set("maxDate", null);
                }
            },
            
            // FIX DE EXPERIENCIA AL CERRAR EL CALENDARIO
            onClose: function(selectedDates, dateStr, instance) {
                if (selectedDates.length === 1) {
                    instance.clear();
                    instance.set("maxDate", null); // Limpiamos también el límite
                }
            }
        });
    });

    // 2. FIX DE SEGURIDAD: PREVENIR EL ENVÍO VACÍO (Esto queda igual que antes)
    const formsReserva = document.querySelectorAll('form[action*="alquileres/reservar"]');
    
    formsReserva.forEach(form => {
        form.addEventListener('submit', function(e) {
            const inputFecha = form.querySelector('.input-rango-fechas');
            if (!inputFecha.value || !inputFecha.value.includes(' a ')) {
                e.preventDefault(); 
                alert("Por favor, selecciona un rango de fechas completo (Día de retiro y Día de devolución) en el calendario.");
            }
        });
    });

});