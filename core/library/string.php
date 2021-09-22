<?php
return $this->string = new class(){
    public $version = '2.0';
    /**
	 * Pobranie tekstu pomiędzy ciągu znaków
	 * <br><br><b>Błędy:</b><br>
	 * 1: Błędny $offset (mniejszy od -1)
	 * @param string $string
	 * @param string $start Początkowy znak
	 * @param string $end Końcowy znak
	 * @param int $offset
	 * @return mixed
	 */
	public function between(string $string, string $start, string $end, int $offset = 0) : mixed {
		if ($offset < -1) {
			return core::setError(1, 'offset error');
		}

		$return = [];

        do {
            $position_start = strpos($string, $start) + strlen($start);

            if (strlen($string) < $position_start + 1 || empty($string)) {
                break;
            }

            $position_end = strpos($string, $end, $position_start+1);

            $return[] = substr($string, $position_start, $position_end - $position_start);

            if ($offset === -1) {
                $string = substr($string, $position_end+strlen($end));

            } else {
                break;
            }
        } while (true);

		return $offset === -1 ? $return : ($return[$offset] ?? null);
	}

	/**
	 * Pobranie pozycji tekstu
	 * <br><br><b>Błędy:</b><br>
	 * 1: Błędny $offset (mniejszy od -1)
	 * @param string $string Ciąg znaków
	 * @param string $searchString Ciąg do wyszukania
	 * @param int $offset
	 * @return int
	 */
	public function strpos(string $string, string $searchString, int $offset = 0) : int {
		if ($offset < 0) {
			return core::setError(1, 'offset error', 'offset must be greater than -1');
		}

		$stringLen = strlen($string);
		$searchStringLen = strlen($searchString);

		for ($i = 0; $i <= $stringLen - 1; $i++) {
			if ($string[$i] === $searchString[0]) {
				if ($i + $searchStringLen > $stringLen) {
					break;
				}

				$generateString = '';

				for ($x = 0; $x <= $searchStringLen - 1; $x++) {
					$generateString .= $string[$i + $x];
				}

				if ($generateString === $searchString) {
					if ($offset === 0) {
						return $i;
					}

					$offset--;
				}
			}
		}

		return -1;
	}

    /**
     * Generowanie ciągu znaków
     * <br><br><b>Błędy:</b><br>
     * 1: Błędna długość (musi być większa lub równa 1)
     * @param int $length Długość wygenerowanego ciągu
     * @param array|bool[] $data <p>
     * [<br />
     * true // [0-9]<br />
     * true // [a-z]<br />
     * true // [A-Z]<br />
     * true // [!@#%^&*()_+=-}{[]?]<br />
     * ]
     * </p>
     * @return string
     * @throws Exception
     */
	public function generateString(int $length = 15, array $data = [true, true, true, true]) : string {
		if ($length <= 0) {
			return core::setError(1, 'length error', 'length must be greate than 1');
		}

		$return = '';
		$string = '';

		if ($data[0]) {
			$string .= '0123456789';
		}

		if (isset($data[1]) && $data[1]) {
			$string .= 'abcdefghijklmnopqrstuvwxyz';
		}

		if (isset($data[2]) && $data[2]) {
			$string .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
		}

		if (isset($data[3]) && $data[3]) {
			$string .= '!@#%^&*()_+=-}{[]?';
		}

		$stringLen = strlen($string);

		for ($i = 1; $i <= $length; $i++) {
			$return .= $string[random_int(1, $stringLen) - 1];
		}

		return $return;
	}

	/**
	 * Zabezpieczenie zmiennej
	 * @param string $string
	 * @return string
	 */
	public function clean(string $string) : string {
		return addslashes(strip_tags(trim($string)));
	}

	/**
	 * Usuwanie `Quotes` z ciagu znaków (na początku i końcu)
	 * @param string $string
	 * @return string
	 */
	public function removeQuotes(string $string) : string {
		if ($string === '') {
			return $string;
		}

		$list = ['`', '"', '\''];
		$searchFirstInt = array_search($string[0], $list);
		$searchFirst = $searchFirstInt > -1;
		$searchLast = $searchFirst === true && substr($string, strlen($string) - 1) === $list[$searchFirstInt];

		if ($searchFirst && $searchLast) {
			return substr($string, 1, -1);
		}

		return $string;
	}

	/**
	 * Zliczenie występowań wyszukiwanego ciągu znaków
	 * @param string $string
	 * @param string $search
	 * @return int
	 */
	public function countString(string $string, string $search) : int {
		$findCount = 0;

		while (true) {
			if ($this->strpos($string, $search, $findCount) === -1) {
				break;
			}

			$findCount++;
		}
		return $findCount;
	}

	/**
	 * Konwenterowanie treści  (bardziej czytelne niż date)
	 * @param string $string <p>
	 * {date} - Y-m-d H:i:s<br />
	 * {year} - Y<br />
	 * {month} - m<br />
	 * {day} - d<br />
	 * {hour} - H<br />
	 * {min} - i<br />
	 * {sec} - s<br />
	 * </p>
	 * @return array|string
	 */
	public function convertString(string $string) : array|string {
		return str_replace(
			['{date}', '{year}', '{month}', '{day}', '{hour}', '{min}', '{sec}'],
			[date('Y-m-d H:i:s'), date('Y'), date('m'), date('d'), date('H'), date('i'), date('s')],
			$string
		);
	}
}