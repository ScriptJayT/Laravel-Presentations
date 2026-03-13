export type UseInitialsReturn = {
    getInitials: (fullName?: string) => string;
};

function isEmoji(text: string) {
    return /\p{Emoji}/u.test(text);
}
export function getInitials(fullName?: string): string {
    if (!fullName) return 'NN';
    const names = fullName.trim().split(' ');
    if (names.length === 0) return 'NN';

    const firstLetters = names.map(_name => {
        _name = _name.trim();
        if(_name.length < 1) return null;
        if(isEmoji(_name)) return "~";
        return _name.charAt(0);
    }).filter(_n => _n !== null);

    if(firstLetters.length === 0) return 'NN';
    const firstname = firstLetters[0];
    const lastname = firstLetters[firstLetters.length - 1];
    if(firstLetters.length === 1) return firstname.toUpperCase();
    return `${firstname}${lastname}`.toUpperCase();
}

export function useInitials(): UseInitialsReturn {
    return { getInitials };
}
