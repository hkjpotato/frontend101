import java.util.HashMap;
public class Twitter {
	public static void main(String[] arg) {
		System.out.println("hello world");

		Child child = new Child();
		child.report();



		Abs crazy = new Abs() {
			public void report() {
				System.out.println("annoymous report");
			}
		}; 

		crazy.report();

		HashMap<String, String> map = new HashMap<String, String>();

		new Person().say();
	}

	public static abstract class Abs {
		abstract void report();
	}

	public static class Child extends Abs{
		public void report() {
			System.out.println("child report");
		}
	}

	public static class Person {
		// private String value;

		public Person() {
			value = "hkj";
		}

		public void say() {
			System.out.println(this.value + "say");
		}
	}
} 
