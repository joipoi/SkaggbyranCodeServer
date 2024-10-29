class CodeEditor {
    constructor(elementId, options = {}) {
        this.editor = CodeMirror.fromTextArea(document.getElementById(elementId), {
            lineNumbers: true,
            mode: "javascript",
            theme: "monokai",
            autoCloseBrackets: true,
            viewportMargin: Infinity,  // This allows the editor to expand
            ...options
        });

        this.outputDiv = document.getElementById(options.outputId || "output");
        this.runButton = document.getElementById(options.runButtonId || "run-button");

        this.runButton.addEventListener("click", () => this.runCode());
    }

    setValue(code) {
        this.editor.setValue(code);
    }

    runCode() {
        this.outputDiv.innerHTML = "";
        const code = this.editor.getValue();
        
        const originalConsoleLog = console.log;
        console.log = (...args) => {
            this.outputDiv.innerHTML += "<p>" + args.join(" ") + "</p>";
            originalConsoleLog.apply(console, args);
        };
        
        try {
            eval(code);
        } catch (error) {
            console.log("Error: " + error.message);
        }
        
        console.log = originalConsoleLog;
    }
}