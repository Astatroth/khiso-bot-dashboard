String.prototype.truncate = String.prototype.truncate ||
    function ( n, useWordBoundary ){
        if (this.length <= n) { return this; }
        const subString = this.slice(0, n-1); // the original check
        return (useWordBoundary
            ? subString.slice(0, subString.lastIndexOf(" "))
            : subString) + "...";
    };
