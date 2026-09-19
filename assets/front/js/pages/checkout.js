(function(){
    const payBtn = document.getElementById('pay_drop_now');
    if(!payBtn) return;

    const msgInput = document.getElementById('drop_dj_message');
    const errorBox = document.getElementById('drop_message_error');
    const wordsCounter = document.getElementById('drop_words_counter');

    function countWords(text){
        const clean = (text || '').trim().replace(/\s+/g, ' ');
        if(!clean) return 0;
        return clean.split(' ').length;
    }

    function showError(message){
        if(!errorBox) return;
        errorBox.textContent = message;
        errorBox.classList.remove('hidden');
        msgInput.classList.add('border-red-400', 'ring-2', 'ring-red-200');
    }

    function clearError(){
        if(!errorBox) return;
        errorBox.textContent = '';
        errorBox.classList.add('hidden');
        msgInput.classList.remove('border-red-400', 'ring-2', 'ring-red-200');
    }

    function updateCounter(){
        if(!msgInput || !wordsCounter) return;

        const maxWords = parseInt(msgInput.getAttribute('data-max-words') || '20', 10);
        const words = countWords(msgInput.value);

        wordsCounter.textContent = words + ' / ' + maxWords + ' words';

        if(words > maxWords){
            wordsCounter.classList.remove('text-blue-700');
            wordsCounter.classList.add('text-red-600');
        }else{
            wordsCounter.classList.remove('text-red-600');
            wordsCounter.classList.add('text-blue-700');
        }
    }

    if(msgInput){
        updateCounter();

        msgInput.addEventListener('input', function(){
            let value = msgInput.value || '';
            value = value.replace(/\s+/g, ' ').replace(/^\s+/, '');
            msgInput.value = value;

            updateCounter();
            clearError();
        });
    }

    payBtn.addEventListener('click', async function(e){
        if(!msgInput) return;

        e.preventDefault();

        const orderId = payBtn.getAttribute('data-order-id');
        const msg = (msgInput.value || '').trim();
        const maxWords = parseInt(msgInput.getAttribute('data-max-words') || '20', 10);
        const totalWords = countWords(msg);

        clearError();

        if(msg === ''){
            showError('You must write the message for your drop before continuing.');
            msgInput.focus();
            return;
        }

        if(msg.length > 180){
            showError('Message too long (max 180 chars).');
            msgInput.focus();
            return;
        }

        if(totalWords > maxWords){
            showError('This drop only allows up to ' + maxWords + ' words.');
            msgInput.focus();
            return;
        }

        const oldHtml = payBtn.innerHTML;
        payBtn.innerHTML = 'Saving message...';
        payBtn.style.pointerEvents = 'none';
        payBtn.style.opacity = '0.85';

        try{
            const res = await fetch(window.DMB.baseUrl + 'drops/save_drop_message', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8' },
                body: new URLSearchParams({
                    order_id: orderId,
                    dj_message: msg
                })
            });

            const data = await res.json();

            if(!data || !data.success){
                payBtn.innerHTML = oldHtml;
                payBtn.style.pointerEvents = '';
                payBtn.style.opacity = '';
                showError(data && data.message ? data.message : 'Error saving message.');
                return;
            }

            window.location.href = payBtn.getAttribute('href');

        }catch(err){
            payBtn.innerHTML = oldHtml;
            payBtn.style.pointerEvents = '';
            payBtn.style.opacity = '';
            showError('Connection error saving message.');
        }
    });
})();
