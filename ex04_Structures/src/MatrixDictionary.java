import java.sql.Array;

public class MatrixDictionary<K, V> implements Dictionary<K, V>
{
	protected int bitDepth;
	protected int pointer = 0;
	protected K[][] keys = (K[][]) new Object[0][0];
	protected V[][] vals = (V[][]) new Object[0][0];


	public MatrixDictionary(int vector)
	{
		this.bitDepth = vector;
	}

	public MatrixDictionary()
	{
		this(100);
	}

	@Override
	public void put(K key, V value)
	{
		if (this.pointer >= this.getSize())
		{
			this.resize();
		}

		int y = this.pointer / this.bitDepth;
		int x = this.pointer % this.bitDepth;

		this.keys[y][x] = key;
		this.vals[y][x] = value;

		this.pointer++;
	}

	@Override
	public V get(K key)
	{
		for (int i = 0; i < this.keys.length; i++)
		{
			for (int j = 0; j < this.bitDepth; j++)
			{
				if (key.equals(this.keys[i][j]))
				{
					return this.vals[i][j];
				}
			}
		}
		return null;
	}

	public Object[] getByIndex(int index)
	{
		int y = index / this.bitDepth;
		int x = index % this.bitDepth;
		K key = this.keys[y][x];
		V val = this.vals[y][x];

		return new Object[]{key, val};
	}

	@Override
	public V del(K key)
	{
		//I do not want to :(
		return null;
	}

	protected void resize()
	{
		K[][] newKeys = (K[][]) new Object[this.keys.length + 1][this.bitDepth];
		V[][] newVals = (V[][]) new Object[this.keys.length + 1][this.bitDepth];

		for (int i = 0; i < this.keys.length; i++)
		{
			newKeys[i] = this.keys[i];
			newVals[i] = this.vals[i];
		}
		this.keys = newKeys;
		this.vals = newVals;
	}

	public int getSize()
	{
		return this.keys.length * this.bitDepth;
	}

	public int getPointer()
	{
		return this.pointer;
	}
	public boolean isEmpty()
	{
		return false;
	}
}
