public class Main
{
	public static void main(String[] args)
	{
		Dictionary<String, String> single = new SingleDictionary<>();
		Dictionary<String, String> vector = new VectorDictionary<>(100);
		Dictionary<String, String> factor = new FactorDictionary<>();
		Dictionary<String, String> matrix = new MatrixDictionary<>();

		testPut(single, 10000);
		testPut(vector, 100000);
		testPut(factor, 1000000);
		testPut(matrix, 1000000);

		testDel(single, 10000);
		testDel(vector, 10000);
		testDel(factor, 10000);
//		testDel(matrix, 1000000);
	}

	private static void testPut(Dictionary<String, String> dictionary, int total)
	{
		long start = System.currentTimeMillis();
		for (int j = 0; j < total; j++)
		{
			dictionary.put("" + j, "" + j);
		}
		System.out.println(dictionary +
				" testPut: input -> " + total +
				" actual size: -> " + dictionary.getSize() +
				" actual elements: -> " + dictionary.getPointer() +
				" entities for the milliseconds: " +
				(System.currentTimeMillis() - start)
		);
	}

	private static void testDel(Dictionary<String, String> dictionary, int total)
	{
		long start = System.currentTimeMillis();
		for (int j = 0; j < total; j++)
		{
			dictionary.del("" + j);
		}
		System.out.println(dictionary +
				" testDel: input -> " + total +
				" actual size: -> " + dictionary.getSize() +
				" actual elements: -> " + dictionary.getPointer() +
				" entities for the milliseconds: " +
				(System.currentTimeMillis() - start)
		);
	}
}
