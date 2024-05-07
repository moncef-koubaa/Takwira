const stadiumCards=document.querySelectorAll('.stadiumCard');
stadiumCards.forEach(stadiumCard=>{
    const stadiumId=stadiumCard.getAttribute('data-stadium-id');
    console.log(stadiumCard);
    const deleteButton=stadiumCard.querySelector('.confirmDeleteButton');
    deleteButton.addEventListener('click',function(){
        const xhr = new XMLHttpRequest();
        xhr.open('POST', deleteStadiumPath, true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onload = function() {
            if (xhr.status === 200) {
                // Success message or any further action
                console.log('Stadium deleted successfully');
                window.location.reload();
            } else {
                console.error('Error deleting stadium');
            }
        };

        xhr.send(JSON.stringify({ stadiumId: stadiumId }));
    });

    const monitorButton=stadiumCard.querySelector('.monitorButton');
    monitorButton.addEventListener('click',function (){
        window.location.href=monitorStadiumPath+ "?stadiumId=" + stadiumId;
    });

    const editButton=stadiumCard.querySelector('.editButton');
    editButton.addEventListener('click',function (){
        window.location.href = addStadiumPath+'/' + stadiumId;

    });

});


