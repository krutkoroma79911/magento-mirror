function validateEmail(email) {
    var regular = /[A-Z0-9._%+-]+@[A-Z0-9.-]+.[A-Z]{2,4}/igm;
    if (regular.test(email)) {
        return (true);
    }
    return (false);
}