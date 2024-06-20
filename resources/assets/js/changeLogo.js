document.addEventListener('DOMContentLoaded', () => {
    let image = document.getElementById('newLogo');

    const allowedLogoType = ['image/jpeg', 'image/jpg', 'image/png'];

    let newLogo = [];

    let btnFile = document.getElementById('chooseNewLogo');

    const message = document.getElementById('bad-file-extension');

    btnFile.addEventListener('change', (e) => {
        const files = e.target.files;

        for (let file in files){
            if (allowedLogoType.includes(files[file].type)) {
                newLogo.push(file);
                image.src = URL.createObjectURL(files[file]);
                message.innerHTML = '';
                break;
            }
            newLogo = [];
        }

        if (newLogo.length === 0){
            image.src = '';
            image.alt = '';
            message.innerHTML = 'Only jpeg, jpg, png files allowed';
        }
    });
});
