import math
import sys

# --- Colors for Terminal ---
class Colors:
    HEADER = '\033[95m'
    BLUE = '\033[94m'
    GREEN = '\033[92m'
    YELLOW = '\033[93m'
    RED = '\033[91m'
    ENDC = '\033[0m'
    BOLD = '\033[1m'

class ScientificCLI:
    def __init__(self):
        self.history = []
        self.last_ans = 0
        # Create a safe dictionary of math functions to allow in eval()
        self.safe_dict = {k: v for k, v in math.__dict__.items() if not k.startswith("__")}
        self.safe_dict.update({
            'abs': abs,
            'round': round,
            'ans': self.last_ans
        })

    def print_welcome(self):
        print(f"{Colors.HEADER}{Colors.BOLD}=== Python Scientific CLI Calculator ==={Colors.ENDC}")
        print(f"{Colors.BLUE}Supported:{Colors.ENDC} +, -, *, /, **, ( ), sqrt, log, sin, cos, tan, pi, e")
        print(f"{Colors.BLUE}Commands:{Colors.ENDC} 'quit' to exit, 'history' for logs, 'clear' to clean screen")
        print(f"{Colors.YELLOW}Tip:{Colors.ENDC} Use 'ans' to use the previous result.\n")

    def update_ans(self, value):
        self.last_ans = value
        self.safe_dict['ans'] = value

    def run(self):
        self.print_welcome()

        while True:
            try:
                # Get input with a styled prompt
                expression = input(f"{Colors.GREEN}Calc > {Colors.ENDC}").strip()

                if not expression:
                    continue

                # Handle Commands
                if expression.lower() in ['quit', 'exit']:
                    print("Goodbye!")
                    break
                
                if expression.lower() == 'history':
                    print(f"\n{Colors.BOLD}--- Calculation History ---{Colors.ENDC}")
                    for idx, item in enumerate(self.history, 1):
                        print(f"{idx}. {item}")
                    print("")
                    continue

                if expression.lower() == 'clear':
                    print("\033c", end="") # ANSI escape to clear terminal
                    self.print_welcome()
                    continue

                # --- THE CALCULATION ENGINE ---
                # We use Python's eval(), but restricted to math functions for safety.
                # We replace '^' with '**' because Python uses ** for power.
                
                clean_expression = expression.replace('^', '**')
                
                result = eval(clean_expression, {"__builtins__": None}, self.safe_dict)
                
                # Formatting result
                if isinstance(result, float):
                    result = round(result, 8) # Clean up floating point errors
                    if result.is_integer():
                        result = int(result)

                # Update History and Memory
                self.update_ans(result)
                self.history.append(f"{expression} = {result}")

                # Print Result
                print(f"{Colors.YELLOW}   = {result}{Colors.ENDC}")

            except SyntaxError:
                print(f"{Colors.RED}Error: Invalid Syntax. Check your brackets or operators.{Colors.ENDC}")
            except ZeroDivisionError:
                print(f"{Colors.RED}Error: Cannot divide by Zero.{Colors.ENDC}")
            except NameError as e:
                print(f"{Colors.RED}Error: Unknown function or variable. ({e}){Colors.ENDC}")
            except Exception as e:
                print(f"{Colors.RED}Error: {e}{Colors.ENDC}")

if __name__ == "__main__":
    calc = ScientificCLI()
    calc.run()