import tkinter as tk
from tkinter import messagebox
import math

class AdvancedCalculator:
    def __init__(self, root):
        self.root = root
        self.root.title("Python Calculator")
        self.root.geometry("400x600")
        self.root.resizable(False, False)

        # Variable to store current expression
        self.expression = ""
        self.input_text = tk.StringVar()

        # --- Display Screen ---
        input_frame = self.create_display()
        input_frame.pack(side=tk.TOP)

        # --- Buttons ---
        btns_frame = self.create_buttons()
        btns_frame.pack()

        # --- Key Bindings (Keyboard Support) ---
        self.root.bind('<Return>', lambda event: self.btn_equal())
        self.root.bind('<BackSpace>', lambda event: self.btn_clear())

    def create_display(self):
        frame = tk.Frame(self.root, width=400, height=50, bd=0, highlightbackground="black", highlightcolor="black", highlightthickness=1)
        frame.pack(side=tk.TOP)

        input_field = tk.Entry(frame, font=('arial', 24, 'bold'), textvariable=self.input_text, width=50, bg="#eee", bd=0, justify=tk.RIGHT)
        input_field.grid(row=0, column=0)
        input_field.pack(ipady=15) # Increase height of input field
        return frame

    def create_buttons(self):
        frame = tk.Frame(self.root, width=400, height=450, bg="grey")
        
        # Button Layout Configuration
        # Text, Row, Column, Width, Height, Function (optional customized)
        buttons = [
            ('C', 1, 0, 1, 1), ('DEL', 1, 1, 1, 1), ('√', 1, 2, 1, 1), ('/', 1, 3, 1, 1),
            ('7', 2, 0, 1, 1), ('8', 2, 1, 1, 1), ('9', 2, 2, 1, 1), ('*', 2, 3, 1, 1),
            ('4', 3, 0, 1, 1), ('5', 3, 1, 1, 1), ('6', 3, 2, 1, 1), ('-', 3, 3, 1, 1),
            ('1', 4, 0, 1, 1), ('2', 4, 1, 1, 1), ('3', 4, 2, 1, 1), ('+', 4, 3, 1, 1),
            ('0', 5, 0, 2, 1), ('.', 5, 2, 1, 1), ('=', 5, 3, 1, 1),
            ('(', 6, 0, 1, 1), (')', 6, 1, 1, 1), ('^', 6, 2, 1, 1), ('π', 6, 3, 1, 1)
        ]

        for btn_props in buttons:
            text, row, col, colspan, rowspan = btn_props
            
            # Define specific commands for special buttons
            if text == 'C':
                cmd = lambda: self.btn_clear()
            elif text == 'DEL':
                cmd = lambda: self.btn_delete()
            elif text == '=':
                cmd = lambda: self.btn_equal()
            elif text == '√':
                cmd = lambda: self.btn_sqrt()
            elif text == '^':
                cmd = lambda: self.btn_click('**') # Python uses ** for power
            elif text == 'π':
                cmd = lambda: self.btn_click(str(math.pi))
            else:
                cmd = lambda t=text: self.btn_click(t)

            # Styling based on button type
            bg_color = "#fff"
            if text in ['/', '*', '-', '+', '=', '^', '√']:
                bg_color = "#f0f0f0" # Light grey for operators
            if text == '=':
                bg_color = "#4CAF50" # Green for equals
                fg_color = "white"
            else:
                fg_color = "black"

            tk.Button(frame, text=text, fg=fg_color, width=10 * colspan, height=3, bd=0, bg=bg_color, cursor="hand2",
                      command=cmd).grid(row=row, column=col, padx=1, pady=1, sticky="nsew", columnspan=colspan)

        # Configure grid weights so buttons expand evenly
        for i in range(4):
            frame.grid_columnconfigure(i, weight=1)
        for i in range(1, 7):
            frame.grid_rowconfigure(i, weight=1)
            
        return frame

    def btn_click(self, item):
        self.expression = self.expression + str(item)
        self.input_text.set(self.expression)

    def btn_clear(self):
        self.expression = ""
        self.input_text.set("")

    def btn_delete(self):
        self.expression = self.expression[:-1]
        self.input_text.set(self.expression)

    def btn_equal(self):
        try:
            # eval() is a powerful function that calculates the string math
            result = str(eval(self.expression)) 
            self.input_text.set(result)
            self.expression = result # Store result for next operation
        except ZeroDivisionError:
            self.input_text.set("Error")
            self.expression = ""
        except SyntaxError:
            self.input_text.set("Error")
            self.expression = ""

    def btn_sqrt(self):
        try:
            result = str(math.sqrt(float(self.expression)))
            self.input_text.set(result)
            self.expression = result
        except:
            self.input_text.set("Error")
            self.expression = ""

if __name__ == "__main__":
    # Create the main window
    root = tk.Tk()
    # Initialize application
    app = AdvancedCalculator(root)
    # Run the main event loop
    root.mainloop()