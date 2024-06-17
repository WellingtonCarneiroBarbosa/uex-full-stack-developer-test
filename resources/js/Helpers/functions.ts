export function ucwords (str: string): string {
    return str.toLowerCase().replace(/\b[a-z]/g, function(letter) {
        return letter.toUpperCase();
    });
}

export function ucfirst (str: string): string {
    return str.charAt(0).toUpperCase() + str.slice(1);
}


