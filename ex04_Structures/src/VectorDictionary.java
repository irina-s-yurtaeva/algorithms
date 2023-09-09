public class VectorDictionary<K, V> implements Dictionary<K, V>
{
	public K[] keys;
	public V[] vals;
	public int vector;
	protected int pointer = 0;

	public VectorDictionary(int vector)
	{
		this.keys = (K[]) new Object[vector];
		this.vals = (V[]) new Object[vector];
		this.vector = vector;
	}

	@Override
	public void put(K key, V value)
	{
		if (this.pointer >= this.getSize())
		{
			this.resize();
		}
		this.keys[this.pointer] = key;
		this.vals[this.pointer] = value;
		this.pointer++;
	}

	@Override
	public V get(K key)
	{
		for (int i = 0; i < this.pointer; i++)
		{
			if (key.equals(this.keys[i]))
			{
				return this.vals[i];
			}
		}
		return null;
	}

	@Override
	public V del(K key)
	{
		V result = null;
		int index = 0;
		for (int i = 0; i < this.getSize(); i++)
		{
			if (key.equals(this.keys[i]))
			{
				result = this.vals[i];
				index = i;
				break;
			}
		}
		if (result != null)
		{
			K[] newKeys = (K[]) new Object[this.keys.length - 1];
			V[] newVals = (V[]) new Object[this.keys.length - 1];
			System.arraycopy(this.keys, 0, newKeys, 0, index);
			System.arraycopy(this.keys, index + 1, newKeys, index, this.keys.length - 1 - index);
			System.arraycopy(this.vals, 0, newVals, 0, index);
			System.arraycopy(this.vals, index + 1, newVals, index, this.keys.length - 1 - index);

			this.keys = newKeys;
			this.vals = newVals;
			this.pointer--;
		}

		return result;
	}

	protected void resize()
	{
		K[] newKeys = (K[]) new Object[this.getSize() + this.vector];
		V[] newVals = (V[]) new Object[this.getSize() + this.vector];
		for (int i = 0; i < this.getSize(); i++)
		{
			newKeys[i] = this.keys[i];
			newVals[i] = this.vals[i];
		}
		this.keys = newKeys;
		this.vals = newVals;
	}

	public int getSize()
	{
		return this.keys.length;
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
