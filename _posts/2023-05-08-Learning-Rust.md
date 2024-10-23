---
layout: post
title:  "Learning Rust part 1"
date:   2023-05-08 12:00:00
categories: learning rust Rust
published: false
---

## Rust

### My plan to learn Rust

I like this tutorial series [gentle intro to Rust](https://stevedonovan.github.io/rust-gentle-intro/readme.html)

### Install Rust

```bash
$ curl https://sh.rustup.rs -sSf | sh
$ rustup component add rust-docs
```

### Notes as I read

#### Basic rust program

`main.rs`
```rust
fn main() {
    println!("Hello, world!");
}
```

Compile main.rs with rustc. `rustc main.rs`

#### Cargo

For everything other than really basic rust programs use cargo.

Using cargo

```bash
cargo new package_name

# Creates package_name/
# package_name/src/main.rs
# package_name/Cargo.toml  <- put dependency info in there.
# The top-level project directory is just for README files, license information, configuration files, and anything else not related to your code.

cd package_name/

# For debugging and fast checking 
cargo check

# Build the executeable
# add --release for prod
cargo build  

# Run it manually
./target/debug/package_name

# Built it and Run it with cargo
cargo run
```

#### Command line args

Simple example

```rust
use std::env;

fn main() {
    let first = env::args().nth(1).expect("please supply an argument");
    let n: i32 = first.parse().expect("not an integer!");
    // do your magic
}
```

#### Reading from files

```rust
// file2.rs
use std::env;
use std::fs::File;
use std::io::Read;
use std::io;

// Verbose version
fn read_to_string(filename: &str) -> Result<String,io::Error> {
    let mut file = match File::open(&filename) {
        Ok(f) => f,
        Err(e) => return Err(e),
    };
    let mut text = String::new();
    match file.read_to_string(&mut text) {
        Ok(_) => Ok(text),
        Err(e) => Err(e),
    }
}

// Cleaner version
fn read_to_string(filename: &str) -> io::Result<String> {
    let mut file = File::open(&filename)?;
    let mut text = String::new();
    file.read_to_string(&mut text)?;
    Ok(text)
}

fn main() {
    let file = env::args().nth(1).expect("please supply a filename");

    let text = read_to_string(&file).expect("bad file man!");

    println!("file had {} bytes", text.len());
}

```

Better way to do this

```rust
use std::fs::File;
use std::io;
use std::io::prelude::*;

fn read_all_lines(filename: &str) -> io::Result<()> {
    let mut reader = io::BufReader::new(file);
    let mut buf = String::new();
    while reader.read_line(&mut buf)? > 0 {
        {
            let line = buf.trim_right();
            println!("{}", line);
        }
        buf.clear();
    }
    Ok(())
}
```


#### traits

Here's a little example of defining a trait and implementing it for a particular type.


```rust
// trait1.rs

trait Show {
    fn show(&self) -> String;
}

impl Show for i32 {
    fn show(&self) -> String {
        format!("four-byte signed {}", self)
    }
}

impl Show for f64 {
    fn show(&self) -> String {
        format!("eight-byte float {}", self)
    }
}

fn main() {
    let answer = 42;
    let maybe_pi = 3.14;
    let s1 = answer.show();
    let s2 = maybe_pi.show();
    println!("show {}", s1);
    println!("show {}", s2);
}
// show four-byte signed 42
// show eight-byte float 3.14
```



### Practicing for leetcode

#### Binary Heap

```rust
use std::collections::BinaryHeap;
use std::cmp::Reverse;

fn main() {
    let mut heap = BinaryHeap::new();
    
    // Push elements wrapped in `Reverse` for a min-heap
    heap.push(Reverse(3));
    heap.push(Reverse(5));
    heap.push(Reverse(1));
    heap.push(Reverse(4));
    // Can also just use negatives but then need to remember to negate the 
    // numbers at the end.
    
    // Pop the smallest element
    println!("Smallest element: {}", heap.pop().unwrap().0); // 1
    
    // Continue popping the elements
    while let Some(Reverse(val)) = heap.pop() {
        println!("{}", val);
    }
}
```

#### HashMap

```rust
use std::collections::HashMap;

let mut map: HashMap<(i32, i32),i32> = HashMap::new();

map.insert((1,2), 1);

map.get(&(1,2)); // Return Some(1) or None;
if let Some(x) = map.get(&(1,2)) {
    // do something here
}
// Or
*map.get(&(1,2)).unwrap();
```

#### Indexing strings

Note using `nth()` is O(n) as it has to loop through the string to get to said index.

```rust
let s_chars: Vec<char> = s.chars().collect();
// Now it's order O(1)
s_chars[5]
```


### Let's build micrograd in rust

Cargo steps

``` bash
cargo new micrograd --lib
```

Code in lib.rs

Simplified implementation

```rust
use std::ops::{Add, Mul};
use std::rc::Rc;
use std::cell::RefCell;
// Used for the debug printing
use std::fmt;

pub struct Value {
    pub data: f64,
    pub grad: Rc<RefCell<f64>>,  // Shared, mutable gradient
    _backward: Rc<RefCell<Option<Box<dyn FnMut()>>>>,  // Backward function for backpropagation
}

// Manually implementing Debug to skip the _backward field
impl fmt::Debug for Value {
    fn fmt(&self, f: &mut fmt::Formatter<'_>) -> fmt::Result {
        f.debug_struct("Value")
            .field("data", &self.data)
            .field("grad", &self.grad)
            .finish() // Skip the _backward field
    }
}

// Implementing Clone manually
impl Clone for Value {
    fn clone(&self) -> Self {
        Value {
            data: self.data,
            grad: self.grad.clone(),
            _backward: Rc::new(RefCell::new(None)),  // We ignore _backward here
        }
    }
}

impl Value {
    pub fn new(data: f64) -> Self {
        Value {
            data,
            grad: Rc::new(RefCell::new(0.0)),  // Initialize gradient to 0.0
            _backward: Rc::new(RefCell::new(None)), 
        }
    }
}

impl Add for Value {
    type Output = Value;

    fn add(self, other: Value) -> Value {
        let out = Value::new(self.data + other.data);

        // Cloning references to gradients for use in the closure
        let grad_self = Rc::clone(&self.grad);
        let grad_other = Rc::clone(&other.grad);
        let grad_out = Rc::clone(&out.grad);  // Clone out.grad to use it inside the closure

        // Capture the backward function for both operands
        let backward_self = Rc::clone(&self._backward);
        let backward_other = Rc::clone(&other._backward);

        // Store the backward function
        *out._backward.borrow_mut()= Some(Box::new(move || {
            // Modify gradients for the backpropagation
            *grad_self.borrow_mut() += *grad_out.borrow();
            *grad_other.borrow_mut() += *grad_out.borrow();

            // Recursively trigger the backward functions of inputs
            if let Some(mut backward) = backward_self.borrow_mut().take() {
                backward();
            }
            if let Some(mut backward) = backward_other.borrow_mut().take() {
                backward();
            }
        }));

        out
    }
}

impl Add for &Value {
    type Output = Value;

    fn add(self, other: &Value) -> Value {
        let out = Value::new(self.data + other.data);

        let grad_self = Rc::clone(&self.grad);
        let grad_other = Rc::clone(&other.grad);
        let grad_out = Rc::clone(&out.grad);  // Clone out.grad to use it inside the closure

        // Capture the backward function for both operands
        let backward_self = Rc::clone(&self._backward);
        let backward_other = Rc::clone(&other._backward);

        *out._backward.borrow_mut() = Some(Box::new(move || {
            *grad_self.borrow_mut() += *grad_out.borrow();
            *grad_other.borrow_mut() += *grad_out.borrow();

            // Recursively trigger the backward functions of inputs
            if let Some(mut backward) = backward_self.borrow_mut().take() {
                backward();
            }
            if let Some(mut backward) = backward_other.borrow_mut().take() {
                backward();
            }
        }));

        out
    }
}

impl Mul for Value {
    type Output = Value;

    fn mul(self, other: Value) -> Value {
        let out = Value::new(self.data * other.data);

        // Cloning references to gradients for use in the closure
        let grad_self = Rc::clone(&self.grad);
        let grad_other = Rc::clone(&other.grad);
        let grad_out = Rc::clone(&out.grad);  // Clone out.grad to use it inside the closure

        // Capture the backward function for both operands
        let backward_self = Rc::clone(&self._backward);
        let backward_other = Rc::clone(&other._backward);

        // Store the backward function
        *out._backward.borrow_mut() = Some(Box::new(move || {
            // Modify gradients for the backpropagation
            *grad_self.borrow_mut() += other.data * *grad_out.borrow();
            *grad_other.borrow_mut() += self.data * *grad_out.borrow();

            // Recursively trigger the backward functions of inputs
            if let Some(mut backward) = backward_self.borrow_mut().take() {
                backward();
            }
            if let Some(mut backward) = backward_other.borrow_mut().take() {
                backward();
            }
        }));

        out
    }
}
```

Add tests to check at the end of the file
```rust
#[cfg(test)]
mod tests {
    use super::*;

    #[test]
    fn test_addition() {
        let v1 = Value::new(3.0);
        let v2 = Value::new(2.0);
        let result = v1 + v2;
        assert_eq!(result.data, 5.0);
    }

    #[test]
    fn test_multiplication() {
        let v1 = Value::new(3.0);
        let v2 = Value::new(2.0);
        let result = v1 * v2;
        assert_eq!(result.data, 6.0);
    }


    #[test]
    fn test_function() {
        let v1 = Value::new(3.0);
        let v2 = Value::new(2.0);
        let temp = &v1 + &v2;
        let result = temp * Value::new(4.0);
        *result.grad.borrow_mut() = 1.0;
        // You can now invoke the backward pass manually if needed
        if let Some(mut backward) = result._backward.borrow_mut().take() {
            backward();  // Manually trigger the backpropagation
        }
        assert_eq!(*result.grad.borrow(), 1.0);
        assert_eq!(*v1.grad.borrow(), 4.0);
    }
}
```

```bash
# If it's a binary
cargo run

# For libs
cargo test  # --lib unsure when this flag is needed
```


