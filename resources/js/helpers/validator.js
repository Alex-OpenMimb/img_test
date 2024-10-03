export const validateBlankSpace = ( input ) => {
    const regex = /^\s*$/;
    return !regex.test(input);
}

export const validateDate = (inputDate) => {
    const date = new Date(inputDate);
    return !isNaN(date.getTime());
}

export const validateImageFile = (file) => {
    const validImageTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/svg+xml', 'image/webp'];
    return file && validImageTypes.includes(file.type);
}
